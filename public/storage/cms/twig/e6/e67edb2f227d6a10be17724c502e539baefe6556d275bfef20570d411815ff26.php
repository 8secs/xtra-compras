<?php

/* /var/www/public/themes/xtraice-theme/partials/common/footer.htm */
class __TwigTemplate_c711a1bb243b06c6382433a8d905fd7d101fab93874a87c508f424e1814b7983 extends Twig_Template
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
        <div class=\"col-md-12 text-center\">
            <h2 class=\"section-title border-line wow fadeIn\"><img src=\"";
        // line 4
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/logo.png");
        echo "\" alt=\"Xtraie\" class=\"img-fluid\" /></h2>
        </div>
        <div class=\"col-md-12 social-links text-center\">
            <ul class=\"list-unstyled list-inline wow fadeIn\">
                <li class=\"list-inline-item\"><a href=\"#\"><i class=\"ti-facebook\"></i></a></li>
                <li class=\"list-inline-item\"><a href=\"#\"><i class=\"ti-twitter\"></i></a></li>
                <li class=\"list-inline-item\"><a href=\"#\"><i class=\"ti-google\"></i></a></li>
                <li class=\"list-inline-item\"><a href=\"#\"><i class=\"ti-linkedin\"></i></a></li>
                <li class=\"list-inline-item\"><a href=\"mailto:info@xtraice.com\"><i class=\"ti-envelope\"></i></a></li>
            </ul>
        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "/var/www/public/themes/xtraice-theme/partials/common/footer.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 4,  19 => 1,);
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
        <div class=\"col-md-12 text-center\">
            <h2 class=\"section-title border-line wow fadeIn\"><img src=\"{{ 'assets/images/logo.png'|theme }}\" alt=\"Xtraie\" class=\"img-fluid\" /></h2>
        </div>
        <div class=\"col-md-12 social-links text-center\">
            <ul class=\"list-unstyled list-inline wow fadeIn\">
                <li class=\"list-inline-item\"><a href=\"#\"><i class=\"ti-facebook\"></i></a></li>
                <li class=\"list-inline-item\"><a href=\"#\"><i class=\"ti-twitter\"></i></a></li>
                <li class=\"list-inline-item\"><a href=\"#\"><i class=\"ti-google\"></i></a></li>
                <li class=\"list-inline-item\"><a href=\"#\"><i class=\"ti-linkedin\"></i></a></li>
                <li class=\"list-inline-item\"><a href=\"mailto:info@xtraice.com\"><i class=\"ti-envelope\"></i></a></li>
            </ul>
        </div>
    </div>
</div>", "/var/www/public/themes/xtraice-theme/partials/common/footer.htm", "");
    }
}
