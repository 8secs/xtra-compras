<?php

/* /var/www/public/themes/xtraice-theme/partials/common/footer-bottom.htm */
class __TwigTemplate_fd3880e8bffbd2a4ae563478a9a30ac849a8f3394b10914380a6687d497802e5 extends Twig_Template
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
        echo "<!-- START FOOTER BOTTOM -->
<div id=\"footer-bottom\" class=\"footer-bottom\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-xs-12\">
                <p class=\"copyright wow\">&copy;";
        // line 6
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo " - <span class=\"xtraice\">Xtraice</span></p>
            </div>
        </div>
    </div>
</div>
<!-- END FOOTER BOTTOM -->

<!-- Move to top button -->
<a href=\"#header\" class=\"move-top scroll-section\"><i class=\"ti-arrow-up\"></i></a>";
    }

    public function getTemplateName()
    {
        return "/var/www/public/themes/xtraice-theme/partials/common/footer-bottom.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  26 => 6,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!-- START FOOTER BOTTOM -->
<div id=\"footer-bottom\" class=\"footer-bottom\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-xs-12\">
                <p class=\"copyright wow\">&copy;{{ \"now\"|date(\"Y\") }} - <span class=\"xtraice\">Xtraice</span></p>
            </div>
        </div>
    </div>
</div>
<!-- END FOOTER BOTTOM -->

<!-- Move to top button -->
<a href=\"#header\" class=\"move-top scroll-section\"><i class=\"ti-arrow-up\"></i></a>", "/var/www/public/themes/xtraice-theme/partials/common/footer-bottom.htm", "");
    }
}
