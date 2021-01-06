<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* public/header.html */
class __TwigTemplate_48cadd5c37567f204c4f1f2bd0446a90fe291bbce1a635f139e17ab70c57f57c extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'header' => [$this, 'block_header'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        $this->displayBlock('header', $context, $blocks);
    }

    public function block_header($context, array $blocks = [])
    {
        // line 2
        echo "<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0,user-scalable=no\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
    <meta http-equiv=\"Cache-Control\" content=\"no-cache, no-store, must-revalidate\" />
    <meta http-equiv=\"Pragma\" content=\"no-cache\" />
    <meta http-equiv=\"Expires\" content=\"0\" />
    <title>云茂|优鲜百惠</title>
    <script src=\"";
        // line 10
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/js/Adaptive.js\"></script>
    <link rel=\"stylesheet\" href=\"";
        // line 11
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/css/swiper.min.css\">
    <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/css/style.css\">
    <link rel=\"stylesheet\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/static/customalert/css/xcConfirm.css\">

</head>
";
    }

    public function getTemplateName()
    {
        return "public/header.html";
    }

    public function getDebugInfo()
    {
        return array (  59 => 13,  55 => 12,  51 => 11,  47 => 10,  37 => 2,  31 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{% block header %}
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0,user-scalable=no\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
    <meta http-equiv=\"Cache-Control\" content=\"no-cache, no-store, must-revalidate\" />
    <meta http-equiv=\"Pragma\" content=\"no-cache\" />
    <meta http-equiv=\"Expires\" content=\"0\" />
    <title>云茂|优鲜百惠</title>
    <script src=\"{{__PUBLIC__}}/home/js/Adaptive.js\"></script>
    <link rel=\"stylesheet\" href=\"{{__PUBLIC__}}/home/css/swiper.min.css\">
    <link rel=\"stylesheet\" href=\"{{__PUBLIC__}}/home/css/style.css\">
    <link rel=\"stylesheet\" href=\"{{__PUBLIC__}}/static/customalert/css/xcConfirm.css\">

</head>
{% endblock %}", "public/header.html", "/var/www/html/mortal/app/views/public/header.html");
    }
}
