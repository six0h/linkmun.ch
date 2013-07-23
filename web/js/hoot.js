(function(exports) {

    // Get the base Url of our app
    var baseUrl = document.URL;
    baseUrl = baseUrl.replace('http://','').replace('https://','').replace('\/.*','');
    console.log('BaseURL: ' + baseUrl);

    var ErrDisplay = {
        "div": $('#err'),
        "Err": function(err) {
            console.log(this);
            var that = this.div;
            this.div.html(err).show(function() {
                setTimeout(function() {
                    that.hide();
                }, 5000);
            });
        }
    }

    // Tighten up the Ajax calls a bit
    var AJAX = {
        rpc: function(controller,sendData,callback) {
            var dfd = $.Deferred();
            $.ajax({
                url: 'http://' + baseUrl + controller,
                data: sendData,
                cache: false,
                timeout: 6000,
                dataType: 'json',
                type: 'POST'
            })
            .done(function(res) {
                callback(res)
            })
            .fail(function(jqXHR, textStatus, error) {
                ErrDisplay.Err(error);                
            });
        }
    }

    // Model for the list of links below the input box
    var LinkTableModel = {
        "updateList": function() {
            AJAX.rpc('getAll', '',function(res) {
                $('#list').html('');
                for ( item in res.content.reverse() ) {
                    $('#list').append('<li>' + item.shortUrl + ' - ' + item.longUrl + '</li>'); 
                }
            });
            return false;
        }
    }

    // Controller for shortening/expanding links
    var URLController = {
        convertUrl: function(url) {
            url = url.replace(/http\:\/\//,'').replace(/https\:\/\//,'');
            var map = LinkTableModel;
            if(url.match(/hoot\.telenova\.ca/) !== null) {
                var mydata = { "url": url }
                AJAX.rpc('hash',mydata,map.updateList);
            } else {
                url = url.replace(/\/.*/,'');
                var mydata = { "linkid": url }
                AJAX.rpc('x',mydata,function(res) {
                    if(res.code == 200) {
                        $('#url').val(res.message);
                    } else {
                        ErrDisplay.Err(String(res.code) + ' - ' + res.message); 
                    }
                });
            }
        }
    }

    $('#linkSubmit').click(function(e) {
        console.log('this is ok');
        e.preventDefault();
        var content = $('#url').val();
        if(content.length > 0) {
            URLController.convertUrl(content);
        }
    });

})(window);
