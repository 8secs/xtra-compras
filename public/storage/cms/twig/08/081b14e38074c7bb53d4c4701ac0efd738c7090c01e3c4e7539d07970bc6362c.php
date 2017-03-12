<?php

/* /var/www/public/themes/xtraice-theme/pages/home.htm */
class __TwigTemplate_a626eb38570e776130663ad422024fefe921089f3f473c2fc92b144925182f40 extends Twig_Template
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
        echo "<div id=\"main-content\" class=\"main-content-area\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-xs-12 col-sm-12\">
                <div class=\"popular-posts-area\">
                    <h2 class=\"section-title\">";
        // line 6
        echo call_user_func_array($this->env->getFilter('_')->getCallable(), array("Cuenta de usuario"));
        echo "</h2>
                    ";
        // line 7
        $context['__cms_component_params'] = [];
        echo $this->env->getExtension('CMS')->componentFunction("account"        , $context['__cms_component_params']        );
        unset($context['__cms_component_params']);
        // line 8
        echo "                </div>
            </div>
        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "/var/www/public/themes/xtraice-theme/pages/home.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  34 => 8,  30 => 7,  26 => 6,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div id=\"main-content\" class=\"main-content-area\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-xs-12 col-sm-12\">
                <div class=\"popular-posts-area\">
                    <h2 class=\"section-title\">{{ 'Cuenta de usuario'|_ }}</h2>
                    {% component 'account' %}
                </div>
            </div>
        </div>
    </div>
</div>", "/var/www/public/themes/xtraice-theme/pages/home.htm", "");
    }
}
