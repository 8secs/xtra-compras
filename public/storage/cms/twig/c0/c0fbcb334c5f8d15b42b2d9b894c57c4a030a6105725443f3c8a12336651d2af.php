<?php

/* /var/www/public/themes/xtraice-theme/partials/header/header-top.htm */
class __TwigTemplate_40f25bc0e10b32576f0a592e7ea3632aa9ec101094d7313b1c0ae2c9c75904bb extends Twig_Template
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
        echo "<div class=\"container\">
    <div class=\"row\">
        <div class=\"col-lg-6 col-md-6 col-sm-7 hidden-xs-down\">
            <div class=\"header-top-left\">
                ";
        // line 5
        if (((isset($context["layout"]) ? $context["layout"] : null) == "blog")) {
            // line 6
            echo "                <ul class=\"social-icons\">
                    <li><a href=\"";
            // line 7
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["company"]) ? $context["company"] : null), "facebook", array()), "html", null, true);
            echo "\"><i class=\"fa fa-facebook\"></i></a></li>
                    <li><a href=\"";
            // line 8
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["company"]) ? $context["company"] : null), "twitter", array()), "html", null, true);
            echo "\"><i class=\"fa fa-twitter\"></i></a></li>
                    <li><a href=\"";
            // line 9
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["company"]) ? $context["company"] : null), "googleplus", array()), "html", null, true);
            echo "\"><i class=\"fa fa-google-plus\"></i></a></li>
                    <li><a href=\"";
            // line 10
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["company"]) ? $context["company"] : null), "pinterest", array()), "html", null, true);
            echo "\"><i class=\"fa fa-pinterest\"></i></a></li>
                    <li><a href=\"mailto:";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["company"]) ? $context["company"] : null), "email", array()), "html", null, true);
            echo "\"><i class=\"fa fa-envelope\"></i></a></li>
                </ul>
                ";
        } else {
            // line 14
            echo "                <div class=\"top-message\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["company"]) ? $context["company"] : null), "slogan", array()), "html", null, true);
            echo "</div>
                <div class=\"phone-number\"> ";
            // line 15
            echo call_user_func_array($this->env->getFilter('_')->getCallable(), array("Llama gratis al: "));
            echo ": <span>";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["company"]) ? $context["company"] : null), "phone", array()), "html", null, true);
            echo "</span></div>
                ";
        }
        // line 17
        echo "            </div>
        </div>
        <div class=\"col-lg-6 col-md-6 col-sm-5\">
            <div class=\"header-top-right\">
                <!--<div class=\"lang-select\">

                </div>-->
                <div class=\"top-menu\">
                    <ul>
                        <li>
                            <div class=\"lang-select\">
                                ";
        // line 28
        echo call_user_func_array($this->env->getFunction('form_open')->getCallable(), array("open"));
        echo "
                                <select name=\"locale\" data-request=\"onSwitchLocale\" class=\"form-control\">
                                    ";
        // line 30
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["locales"]) ? $context["locales"] : null));
        foreach ($context['_seq'] as $context["code"] => $context["name"]) {
            // line 31
            echo "                                    <option value=\"";
            echo twig_escape_filter($this->env, $context["code"], "html", null, true);
            echo "\" ";
            echo ((($context["code"] == (isset($context["activeLocale"]) ? $context["activeLocale"] : null))) ? ("selected") : (""));
            echo "><i class=\"flag-icon flag-icon-";
            echo twig_escape_filter($this->env, $context["code"], "html", null, true);
            echo "\"></i> ";
            echo twig_escape_filter($this->env, $context["code"], "html", null, true);
            echo "</option>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['code'], $context['name'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        echo "                                </select>
                                ";
        // line 34
        echo call_user_func_array($this->env->getFunction('form_close')->getCallable(), array("close"));
        echo "
                            </div>
                        </li>
                        ";
        // line 37
        if ( !(isset($context["user"]) ? $context["user"] : null)) {
            // line 38
            echo "                        <li><a href=\"";
            echo $this->env->getExtension('Cms\Twig\Extension')->pageFilter("account", array("from" => (isset($context["layout"]) ? $context["layout"] : null)));
            echo "\">";
            echo call_user_func_array($this->env->getFilter('_')->getCallable(), array("Acceso"));
            echo "</a></li>
                        ";
        } else {
            // line 40
            echo "                        <li><a href=\"#\" data-request=\"onLogout\" data-request-data=\"redirect: '/'\" > ";
            echo call_user_func_array($this->env->getFilter('_')->getCallable(), array("Salir"));
            echo "</a></li>
                        ";
        }
        // line 42
        echo "                        ";
        if (((isset($context["layout"]) ? $context["layout"] : null) == "shop")) {
            // line 43
            echo "                            <li><a href=\"";
            echo $this->env->getExtension('Cms\Twig\Extension')->pageFilter("shop/wishlist");
            echo "\">";
            echo call_user_func_array($this->env->getFilter('_')->getCallable(), array("Favoritos"));
            echo "</a></li>
                            <li>
                                <!--<a class=\"cart\" href=\"#\">";
            // line 45
            echo "</a>-->
                                ";
            // line 46
            $context['__cms_partial_params'] = [];
            echo $this->env->getExtension('CMS')->partialFunction("ShopBasket::_cart"            , $context['__cms_partial_params']            );
            unset($context['__cms_partial_params']);
            // line 47
            echo "                            </li>
                        ";
        } elseif ((        // line 48
(isset($context["layout"]) ? $context["layout"] : null) == "blog")) {
            // line 49
            echo "                        <li>
                            <form action=\"#\" method=\"post\">
                                <button type=\"button\" class=\"search-toggler\"><i class=\"fa fa-search\"></i></button>
                            </form>
                        </li>
                        ";
        }
        // line 55
        echo "                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "/var/www/public/themes/xtraice-theme/partials/header/header-top.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  157 => 55,  149 => 49,  147 => 48,  144 => 47,  140 => 46,  137 => 45,  129 => 43,  126 => 42,  120 => 40,  112 => 38,  110 => 37,  104 => 34,  101 => 33,  86 => 31,  82 => 30,  77 => 28,  64 => 17,  57 => 15,  52 => 14,  46 => 11,  42 => 10,  38 => 9,  34 => 8,  30 => 7,  27 => 6,  25 => 5,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"container\">
    <div class=\"row\">
        <div class=\"col-lg-6 col-md-6 col-sm-7 hidden-xs-down\">
            <div class=\"header-top-left\">
                {% if layout == \"blog\" %}
                <ul class=\"social-icons\">
                    <li><a href=\"{{ company.facebook }}\"><i class=\"fa fa-facebook\"></i></a></li>
                    <li><a href=\"{{ company.twitter }}\"><i class=\"fa fa-twitter\"></i></a></li>
                    <li><a href=\"{{ company.googleplus }}\"><i class=\"fa fa-google-plus\"></i></a></li>
                    <li><a href=\"{{ company.pinterest }}\"><i class=\"fa fa-pinterest\"></i></a></li>
                    <li><a href=\"mailto:{{ company.email }}\"><i class=\"fa fa-envelope\"></i></a></li>
                </ul>
                {% else %}
                <div class=\"top-message\">{{ company.slogan }}</div>
                <div class=\"phone-number\"> {{ 'Llama gratis al: '|_ }}: <span>{{ company.phone }}</span></div>
                {% endif %}
            </div>
        </div>
        <div class=\"col-lg-6 col-md-6 col-sm-5\">
            <div class=\"header-top-right\">
                <!--<div class=\"lang-select\">

                </div>-->
                <div class=\"top-menu\">
                    <ul>
                        <li>
                            <div class=\"lang-select\">
                                {{ form_open() }}
                                <select name=\"locale\" data-request=\"onSwitchLocale\" class=\"form-control\">
                                    {% for code, name in locales %}
                                    <option value=\"{{ code }}\" {{ code == activeLocale ? 'selected' }}><i class=\"flag-icon flag-icon-{{ code }}\"></i> {{ code }}</option>
                                    {% endfor %}
                                </select>
                                {{ form_close() }}
                            </div>
                        </li>
                        {% if not user %}
                        <li><a href=\"{{ 'account'|page({ from: layout })}}\">{{ 'Acceso'|_ }}</a></li>
                        {% else %}
                        <li><a href=\"#\" data-request=\"onLogout\" data-request-data=\"redirect: '/'\" > {{ 'Salir'|_ }}</a></li>
                        {% endif %}
                        {% if layout == 'shop' %}
                            <li><a href=\"{{ 'shop/wishlist'|page }}\">{{ 'Favoritos'|_ }}</a></li>
                            <li>
                                <!--<a class=\"cart\" href=\"#\">{# 'Carrito'|_ #}</a>-->
                                {% partial 'ShopBasket::_cart' %}
                            </li>
                        {% elseif layout == 'blog' %}
                        <li>
                            <form action=\"#\" method=\"post\">
                                <button type=\"button\" class=\"search-toggler\"><i class=\"fa fa-search\"></i></button>
                            </form>
                        </li>
                        {% endif %}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>", "/var/www/public/themes/xtraice-theme/partials/header/header-top.htm", "");
    }
}
