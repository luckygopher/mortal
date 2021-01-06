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

/* index/index.html */
class __TwigTemplate_4e521aa36145fc96fdc81589c9270ac7f8c556673cb554cbc9bed2b17374ab93 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
";
        // line 3
        $this->loadTemplate("public/header.html", "index/index.html", 3)->display($context);
        // line 4
        echo "
<body class=\"index\">
<div class=\"box\">
    <!--banner-->
    <div class=\"J_banner banner\">
        <div class=\"swiper-wrapper\">
            <div class=\"box swiper-slide\">
                <a href=\"\" class=\"displayB\">
                    <img src=\"";
        // line 12
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/img/banner.jpg\" alt=\"\" width=\"100%\">
                </a>
            </div>
            <div class=\"box swiper-slide\">
                <a href=\"\" class=\"displayB\">
                    <img src=\"";
        // line 17
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/img/banner.jpg\" alt=\"\" width=\"100%\">
                </a>
            </div>
            <div class=\"box swiper-slide\">
                <a href=\"\" class=\"displayB\">
                    <img src=\"";
        // line 22
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/img/banner.jpg\" alt=\"\" width=\"100%\">
                </a>
            </div>
        </div>
        <div class=\"search\" id=\"search\">
            <i class=\"icon-search\"></i>
            <input type=\"text\">
        </div>
    </div>

    <div class=\"box\">
        <div class=\"hot1\">
            <a href=\"\">
                <img src=\"";
        // line 35
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/img/hot1.jpg\" alt=\"\">
            </a>
        </div>
        <div class=\"hot1\">
            <a href=\"\">
                <img src=\"";
        // line 40
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/img/hot2.jpg\" alt=\"\">
            </a>
            <a href=\"\">
                <img src=\"";
        // line 43
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/img/hot3.jpg\" alt=\"\">
            </a>
        </div>
    </div>
    <div class=\"box\">
        <a href=\"\" class=\"displayB\">
            <img src=\"";
        // line 49
        echo twig_escape_filter($this->env, (isset($context["__PUBLIC__"]) ? $context["__PUBLIC__"] : null), "html", null, true);
        echo "/home/img/banner2.jpg\" class=\"displayB\" width=\"100%\" alt=\"\">
        </a>
    </div>

    <div class=\"box\">
        <div class=\"tabs box\" id=\"J_tabs\">
            <div class=\"tab-nav\">
                <a href=\"#tjcp\" class=\"active\">推荐产品</a>
            </div>
            <div class=\"tab-nav\">
                <a href=\"#jrcx\">今日促销</a>
            </div>
            <div class=\"tab-nav\">
                <a href=\"#xpsj\">新品上架</a>
            </div>
        </div>
        <div class=\"tab-content box\">

            <ul id=\"tjcp\" class=\"content-list box\">
                <notempty name=\"_tjlist\">
                    <volist name=\"_tjlist\" id=\"tj\">
                        <li>
                            <a href=\"\">
                                <img src=\"\" class=\"displayB\" width=\"100%\" alt=\"\">
                            </a>
                            <div class=\"text-box\">
                                <div class=\"text\">
                                    <p>
                                        <a href=\"\">test(11111)</a>
                                    </p>
                                    <span>￥1111/213123(123123嫁鸡随鸡起购)</span>
                                </div>
                                <span onclick=\"addCar(1,2)\" class=\"shopping-care\"></span>
                            </div>
                        </li>
                    </volist>
                    <else/>
                    aOh! 暂时还没有内容!
                </notempty>
            </ul>

            <ul id=\"jrcx\" class=\"content-list box displayN\">
                <notempty name=\"_cxlist\">
                    <volist name=\"_cxlist\" id=\"cx\">
                        <li>
                            <a href=\"#\">
                                <img src=\"#\" class=\"displayB\" width=\"100%\" alt=\"\">
                            </a>
                            <div class=\"text-box\">
                                <div class=\"text\">
                                    <p>
                                        <a href=\"#\">sdf(sdsds)</a>
                                    </p>
                                    <span>￥1232/sdsd(asdaasd起购)</span>
                                </div>
                                <span onclick=\"addCar(1,231)\" class=\"shopping-care\"></span>
                            </div>
                        </li>
                    </volist>
                    <else/>
                    aOh! 暂时还没有内容!
                </notempty>
            </ul>

            <ul id=\"xpsj\" class=\"content-list box displayN\">
                <notempty name=\"_xplist\">
                    <volist name=\"_xplist\" id=\"xp\">
                        <li>
                            <a href=\"#\">
                                <img src=\"#\" class=\"displayB\" width=\"100%\" alt=\"\">
                            </a>
                            <div class=\"text-box\">
                                <div class=\"text\">
                                    <p>
                                        <a href=\"#\">asd(sdad)</a>
                                    </p>
                                    <span>￥121/asda(qweqwewqewq起购)</span>
                                </div>
                                <span onclick=\"addCar(1,2)\" class=\"shopping-care\"></span>
                            </div>
                        </li>
                    </volist>
                    <else/>
                    aOh! 暂时还没有内容!
                </notempty>
            </ul>
        </div>

    </div>
</div>

";
        // line 140
        $this->loadTemplate("public/footer.html", "index/index.html", 140)->display($context);
        // line 141
        echo "</body>

</html>";
    }

    public function getTemplateName()
    {
        return "index/index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  197 => 141,  195 => 140,  101 => 49,  92 => 43,  86 => 40,  78 => 35,  62 => 22,  54 => 17,  46 => 12,  36 => 4,  34 => 3,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html>
{% include \"public/header.html\" %}

<body class=\"index\">
<div class=\"box\">
    <!--banner-->
    <div class=\"J_banner banner\">
        <div class=\"swiper-wrapper\">
            <div class=\"box swiper-slide\">
                <a href=\"\" class=\"displayB\">
                    <img src=\"{{__PUBLIC__}}/home/img/banner.jpg\" alt=\"\" width=\"100%\">
                </a>
            </div>
            <div class=\"box swiper-slide\">
                <a href=\"\" class=\"displayB\">
                    <img src=\"{{__PUBLIC__}}/home/img/banner.jpg\" alt=\"\" width=\"100%\">
                </a>
            </div>
            <div class=\"box swiper-slide\">
                <a href=\"\" class=\"displayB\">
                    <img src=\"{{__PUBLIC__}}/home/img/banner.jpg\" alt=\"\" width=\"100%\">
                </a>
            </div>
        </div>
        <div class=\"search\" id=\"search\">
            <i class=\"icon-search\"></i>
            <input type=\"text\">
        </div>
    </div>

    <div class=\"box\">
        <div class=\"hot1\">
            <a href=\"\">
                <img src=\"{{__PUBLIC__}}/home/img/hot1.jpg\" alt=\"\">
            </a>
        </div>
        <div class=\"hot1\">
            <a href=\"\">
                <img src=\"{{__PUBLIC__}}/home/img/hot2.jpg\" alt=\"\">
            </a>
            <a href=\"\">
                <img src=\"{{__PUBLIC__}}/home/img/hot3.jpg\" alt=\"\">
            </a>
        </div>
    </div>
    <div class=\"box\">
        <a href=\"\" class=\"displayB\">
            <img src=\"{{__PUBLIC__}}/home/img/banner2.jpg\" class=\"displayB\" width=\"100%\" alt=\"\">
        </a>
    </div>

    <div class=\"box\">
        <div class=\"tabs box\" id=\"J_tabs\">
            <div class=\"tab-nav\">
                <a href=\"#tjcp\" class=\"active\">推荐产品</a>
            </div>
            <div class=\"tab-nav\">
                <a href=\"#jrcx\">今日促销</a>
            </div>
            <div class=\"tab-nav\">
                <a href=\"#xpsj\">新品上架</a>
            </div>
        </div>
        <div class=\"tab-content box\">

            <ul id=\"tjcp\" class=\"content-list box\">
                <notempty name=\"_tjlist\">
                    <volist name=\"_tjlist\" id=\"tj\">
                        <li>
                            <a href=\"\">
                                <img src=\"\" class=\"displayB\" width=\"100%\" alt=\"\">
                            </a>
                            <div class=\"text-box\">
                                <div class=\"text\">
                                    <p>
                                        <a href=\"\">test(11111)</a>
                                    </p>
                                    <span>￥1111/213123(123123嫁鸡随鸡起购)</span>
                                </div>
                                <span onclick=\"addCar(1,2)\" class=\"shopping-care\"></span>
                            </div>
                        </li>
                    </volist>
                    <else/>
                    aOh! 暂时还没有内容!
                </notempty>
            </ul>

            <ul id=\"jrcx\" class=\"content-list box displayN\">
                <notempty name=\"_cxlist\">
                    <volist name=\"_cxlist\" id=\"cx\">
                        <li>
                            <a href=\"#\">
                                <img src=\"#\" class=\"displayB\" width=\"100%\" alt=\"\">
                            </a>
                            <div class=\"text-box\">
                                <div class=\"text\">
                                    <p>
                                        <a href=\"#\">sdf(sdsds)</a>
                                    </p>
                                    <span>￥1232/sdsd(asdaasd起购)</span>
                                </div>
                                <span onclick=\"addCar(1,231)\" class=\"shopping-care\"></span>
                            </div>
                        </li>
                    </volist>
                    <else/>
                    aOh! 暂时还没有内容!
                </notempty>
            </ul>

            <ul id=\"xpsj\" class=\"content-list box displayN\">
                <notempty name=\"_xplist\">
                    <volist name=\"_xplist\" id=\"xp\">
                        <li>
                            <a href=\"#\">
                                <img src=\"#\" class=\"displayB\" width=\"100%\" alt=\"\">
                            </a>
                            <div class=\"text-box\">
                                <div class=\"text\">
                                    <p>
                                        <a href=\"#\">asd(sdad)</a>
                                    </p>
                                    <span>￥121/asda(qweqwewqewq起购)</span>
                                </div>
                                <span onclick=\"addCar(1,2)\" class=\"shopping-care\"></span>
                            </div>
                        </li>
                    </volist>
                    <else/>
                    aOh! 暂时还没有内容!
                </notempty>
            </ul>
        </div>

    </div>
</div>

{% include \"public/footer.html\" %}
</body>

</html>", "index/index.html", "/var/www/html/mortal/app/views/index/index.html");
    }
}
