<?php

/* /var/www/public/themes/xtraice-theme/partials/common/nav.htm */
class __TwigTemplate_905be786c147160bf26ef6cd61a3c4a781f7f1e22d3448786179e99c2a65f7e6 extends Twig_Template
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
        $context["nav"] = $this;
        // line 2
        echo "
";
        // line 17
        echo "<nav class=\"main-menu\" id=\"main-menu\">
    <ul class=\"nav navbar-nav main-nav ";
        // line 18
        if ( !twig_test_empty((isset($context["type"]) ? $context["type"] : null))) {
            echo "nav-padding-top pull-xs-left pull-sm-right";
        }
        echo "\">
        ";
        // line 19
        echo $context["nav"]->getrender_menu($this->getAttribute((isset($context["mainMenu"]) ? $context["mainMenu"] : null), "menuItems", array()));
        echo "
    </ul>
</nav>";
    }

    // line 3
    public function getrender_menu($__items__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "items" => $__items__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 4
            $context["nav"] = $this;
            // line 5
            echo "
";
            // line 6
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 7
                $context["itemName"] = $this->getAttribute($context["item"], "title", array());
                // line 8
                echo "
<li class=\"";
                // line 9
                echo (($this->getAttribute($context["item"], "isActive", array())) ? ("active") : (""));
                echo " ";
                echo (($this->getAttribute($context["item"], "isChildActive", array())) ? ("child-active") : (""));
                echo " ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "viewBag", array()), "cssClass", array()), "html", null, true);
                echo "\">
    <a href=\"";
                // line 10
                if ($this->getAttribute($context["item"], "code", array())) {
                    echo "#";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "code", array()), "html", null, true);
                } else {
                    echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "url", array()), "html", null, true);
                }
                echo "\" class=\"scroll-section\">";
                echo call_user_func_array($this->env->getFilter('_')->getCallable(), array((isset($context["itemName"]) ? $context["itemName"] : null)));
                echo "</a>
    ";
                // line 11
                if ($this->getAttribute($context["item"], "items", array())) {
                    // line 12
                    echo "    <ul class=\"sub-menu\">";
                    echo $context["nav"]->getrender_menu($this->getAttribute($context["item"], "items", array()));
                    echo "</ul>
    ";
                }
                // line 14
                echo "</li>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "/var/www/public/themes/xtraice-theme/partials/common/nav.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  93 => 14,  87 => 12,  85 => 11,  74 => 10,  66 => 9,  63 => 8,  61 => 7,  57 => 6,  54 => 5,  52 => 4,  40 => 3,  33 => 19,  27 => 18,  24 => 17,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% import _self as nav %}

{% macro render_menu(items) %}
{% import _self as nav %}

{% for item in items %}
{% set itemName = item.title %}

<li class=\"{{ item.isActive ? 'active' : '' }} {{ item.isChildActive ? 'child-active' : '' }} {{ item.viewBag.cssClass }}\">
    <a href=\"{% if item.code %}#{{ item.code}}{% else %}{{ item.url }}{% endif %}\" class=\"scroll-section\">{{ itemName|_ }}</a>
    {% if item.items %}
    <ul class=\"sub-menu\">{{ nav.render_menu(item.items) }}</ul>
    {% endif %}
</li>
{% endfor %}
{% endmacro %}
<nav class=\"main-menu\" id=\"main-menu\">
    <ul class=\"nav navbar-nav main-nav {% if type is not empty %}nav-padding-top pull-xs-left pull-sm-right{% endif %}\">
        {{ nav.render_menu(mainMenu.menuItems) }}
    </ul>
</nav>", "/var/www/public/themes/xtraice-theme/partials/common/nav.htm", "");
    }
}
