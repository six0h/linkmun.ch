<?php

/* index.html.twig */
class __TwigTemplate_63f5efccfe1b2240cb3b4368ce97996f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("base.html.twig");

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "    <div id=\"wrapper\">
        <div id=\"err\"></div>
        <form method=\"POST\">
            <input type=\"text\" name=\"url\" id=\"url\">
            <input type=\"submit\" value=\"Convert\" name=\"linkSubmit\" id=\"linkSubmit\">
        </form>

        <h1>Your URL's:</h1>
        <ul id=\"list\">
        </ul>
    </div>

    <script src=\"js/jquery.js\"></script>
    <script src=\"js/hoot.js\"></script>
";
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 4,  28 => 3,);
    }
}
