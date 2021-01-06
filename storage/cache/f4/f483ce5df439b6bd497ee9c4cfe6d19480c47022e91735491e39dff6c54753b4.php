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

/* public/footer.html */
class __TwigTemplate_23263b43d0235b83c9a11e125413bf7decfdcde18b11bc2071f592225ca62f1a extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'footer' => [$this, 'block_footer'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        $this->displayBlock('footer', $context, $blocks);
    }

    public function block_footer($context, array $blocks = [])
    {
        // line 2
        echo "<div class=\"footer-box\"></div>
<footer class=\"footer\">
    <a href=\"/Index/index\" class=\"active\">
        <i class=\"icon-home\"></i>
        <span class=\"home-text\">首页</span>
    </a>
    <a href=\"/ShopCar/index\">
        <i class=\"icon-shopping-care\"></i>
        <span class=\"shopping-care-text\">购物车</span>
        <span id='car_num'>121</span>
    </a>
    <a href=\"/User/index\">
        <i class=\"icon-user\"></i>
        <span class=\"user-text\">个人</span>
    </a>
</footer>

<script src=\"";
        // line 19
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/js/jquery-1.9.1.min.js\"></script>
<script src=\"";
        // line 20
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/js/swiper.jquery.min.js\"></script>
<script src=\"";
        // line 21
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/js/tabs.js\"></script>
<script src=\"";
        // line 22
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/static/customalert/js/xcConfirm.js\"></script>
";
    }

    public function getTemplateName()
    {
        return "public/footer.html";
    }

    public function getDebugInfo()
    {
        return array (  68 => 22,  64 => 21,  60 => 20,  56 => 19,  37 => 2,  31 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{% block footer %}
<div class=\"footer-box\"></div>
<footer class=\"footer\">
    <a href=\"/Index/index\" class=\"active\">
        <i class=\"icon-home\"></i>
        <span class=\"home-text\">首页</span>
    </a>
    <a href=\"/ShopCar/index\">
        <i class=\"icon-shopping-care\"></i>
        <span class=\"shopping-care-text\">购物车</span>
        <span id='car_num'>121</span>
    </a>
    <a href=\"/User/index\">
        <i class=\"icon-user\"></i>
        <span class=\"user-text\">个人</span>
    </a>
</footer>

<script src=\"{{__PUBLIC__}}/home/js/jquery-1.9.1.min.js\"></script>
<script src=\"{{__PUBLIC__}}/home/js/swiper.jquery.min.js\"></script>
<script src=\"{{__PUBLIC__}}/home/js/tabs.js\"></script>
<script src=\"{{__PUBLIC__}}/static/customalert/js/xcConfirm.js\"></script>
{% endblock %}", "public/footer.html", "/var/www/html/mortal/app/views/public/footer.html");
    }
}
