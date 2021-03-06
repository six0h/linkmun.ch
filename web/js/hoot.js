(function(exports) {

    var lastUpdated = new String(new Date(2012,01,01).getTime() / 1000);

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
    var WebService = {
        rpc: function(controller,sendData,callback) {
            var dfd = $.Deferred();
            $.ajax({
                url: 'http://' + baseUrl + controller,
                data: sendData,
                cache: false,
                timeout: 20000,
                dataType: 'json',
                type: 'POST'
            })
            .done(function(res) {
                setTimeout(function() {
                    callback(res);
                }, 1000);
            })
            .fail(function(jqXHR, textStatus, error) {
                ErrDisplay.Err(error);                
            });
        }
    }

    // Model for the list of links below the input box
    var LinkTableModel = {
        "updateList": function() {
            WebService.rpc('ah',lastUpdated,function(res) {
                $('#list').html('');
                res.reverse().forEach (function(item) { 
                    var shortlink = 'http://' + baseUrl + 'y/' + item.shortUrl;
                    $('#list').append('<li><a href="' + shortlink + '">' + shortlink + '</a> - ' + item.longUrl + '</li>'); 
                });
            });
            return false;
        }
    }

    var linkUpdater = setInterval(function() { 
        LinkTableModel.updateList(lastUpdated);
        lastUpdated = new String(new Date().getTime() /1000);
    }, 10000);

    // Controller for shortening/expanding links
    var URLController = {
        convertUrl: function(url) {
            url = url.replace(/http\:\/\//,'').replace(/https\:\/\//,'');
            var map = LinkTableModel;
            if(url.match(/linkmun\.ch/) == null) {
                var mydata = { "url": url }
                WebService.rpc('er',mydata,function(res) {
                    map.updateList(res);
                    $('#url').val('http://' + baseUrl + 'y/' + res.url);
                });
            } else {
                url = url.replace(/linkmun\.ch/,'').replace(/http\:\/\//,'').replace(/https\:\/\//,'').replace(/\/y\//,'');
                var mydata = { "url": url }
                WebService.rpc('y',mydata,function(res) {
                    console.log(res);
                    if(res.code == 200) {
                        $('#url').val(res.url);
                    } else {
                        ErrDisplay.Err(String(res.code) + ' - ' + res.message); 
                    }
                });
            }
        }
    }

    $('#linkSubmit').click(function(e) {
        e.preventDefault();
        var content = $('#url').val();
        if(content.length > 0) {
            URLController.convertUrl(content);
        }
    });
    
    LinkTableModel.updateList(lastUpdated);
    lastUpdated = new String(new Date().getTime() /1000);

})(window);
