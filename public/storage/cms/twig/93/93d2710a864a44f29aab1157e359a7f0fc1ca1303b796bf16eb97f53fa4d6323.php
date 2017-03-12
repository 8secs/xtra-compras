<?php

/* /var/www/public/themes/xtraice-theme/partials/header/header-bottom.htm */
class __TwigTemplate_5d46a63c8b54f1e93c03d11cb907bd8cf71c8b7adf2ef6e6ecf8a10b83a9f3ae extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!-- header-bottom start -->
<div class=\"container\">
    <div class=\"row\">
        <div class=\"";
        // line 4
        if (((isset($context["layout"]) ? $context["layout"] : null) != "shop")) {
            echo "col-xs-12 col-md-3";
        } else {
            echo "col-lg-6 col-md-6 col-sm-8 col-xs-12";
        }
        echo "\">
            <div class=\"logo\">
                <a href=\"";
        // line 6
        echo $this->env->getExtension('System\Twig\Extension')->appFilter("/");
        echo "\"><img src=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["company"]) ? $context["company"] : null), "logo", array()), "getPath", array()), "html", null, true);
        echo "\" alt=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["company"]) ? $context["company"] : null), "name", array()), "html", null, true);
        echo "\" height=\"50\" /></a>
            </div>
        </div>
        <div class=\"";
        // line 9
        if (((isset($context["layout"]) ? $context["layout"] : null) != "shop")) {
            echo "col-xs-12 col-md-9";
        } else {
            echo "col-lg-6 col-md-6 col-sm-4 col-xs-12";
        }
        echo "\">
            ";
        // line 10
        if (((isset($context["layout"]) ? $context["layout"] : null) == "shop")) {
            // line 11
            echo "                <div class=\"shop-cart-search\">
                    <!-- cart-total start
                    <div class=\"cart-total\">
                        ";
            // line 15
            echo "                    </div>
                    <!-- cart-total end -->
                    <!-- header-search start -->
                    <div class=\"header-search\">
                        ";
            // line 19
            $context['__cms_partial_params'] = [];
            echo $this->env->getExtension('CMS')->partialFunction("Products::_search"            , $context['__cms_partial_params']            );
            unset($context['__cms_partial_params']);
            // line 20
            echo "                    </div>
                    <!-- header-search end -->
                </div>
            ";
        } else {
            // line 24
            echo "                <div class=\"mainmenu\">
                    ";
            // line 25
            $context['__cms_partial_params'] = [];
            $context['__cms_partial_params']['type'] = "short"            ;
            echo $this->env->getExtension('CMS')->partialFunction("common/nav"            , $context['__cms_partial_params']            );
            unset($context['__cms_partial_params']);
            // line 26
            echo "                </div>
            ";
        }
        // line 28
        echo "        </div>
    </div>
    ";
        // line 30
        if (((isset($context["layout"]) ? $context["layout"] : null) == "shop")) {
            // line 31
            echo "    <div class=\"row\">
        <div class=\"col-xs-12\">
            <div class=\"mainmenu\">
                ";
            // line 34
            $context['__cms_partial_params'] = [];
            echo $this->env->getExtension('CMS')->partialFunction("common/nav"            , $context['__cms_partial_params']            );
            unset($context['__cms_partial_params']);
            // line 35
            echo "            </div>
        </div>
    </div>
    ";
        }
        // line 39
        echo "</div>
<!-- header-bottom end -->";
    }

    public function getTemplateName()
    {
        return "/var/www/public/themes/xtraice-theme/partials/header/header-bottom.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  107 => 39,  101 => 35,  97 => 34,  92 => 31,  90 => 30,  86 => 28,  82 => 26,  77 => 25,  74 => 24,  68 => 20,  64 => 19,  58 => 15,  53 => 11,  51 => 10,  43 => 9,  33 => 6,  24 => 4,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!-- header-bottom start -->
<div class=\"container\">
    <div class=\"row\">
        <div class=\"{% if layout != 'shop' %}col-xs-12 col-md-3{% else %}col-lg-6 col-md-6 col-sm-8 col-xs-12{% endif %}\">
            <div class=\"logo\">
                <a href=\"{{ '/'|app }}\"><img src=\"{{ company.logo.getPath }}\" alt=\"{{ company.name }}\" height=\"50\" /></a>
            </div>
        </div>
        <div class=\"{% if layout != 'shop' %}col-xs-12 col-md-9{% else %}col-lg-6 col-md-6 col-sm-4 col-xs-12{% endif %}\">
            {% if layout == 'shop' %}
                <div class=\"shop-cart-search\">
                    <!-- cart-total start
                    <div class=\"cart-total\">
                        {# partial 'ShopBasket::_shopping-cart' #}
                    </div>
                    <!-- cart-total end -->
                    <!-- header-search start -->
                    <div class=\"header-search\">
                        {% partial 'Products::_search' %}
                    </div>
                    <!-- header-search end -->
                </div>
            {% else %}
                <div class=\"mainmenu\">
                    {% partial 'common/nav' type=\"short\" %}
                </div>
            {% endif %}
        </div>
    </div>
    {% if layout == 'shop' %}
    <div class=\"row\">
        <div class=\"col-xs-12\">
            <div class=\"mainmenu\">
                {% partial 'common/nav' %}
            </div>
        </div>
    </div>
    {% endif %}
</div>
<!-- header-bottom end -->", "/var/www/public/themes/xtraice-theme/partials/header/header-bottom.htm", "");
    }
}
