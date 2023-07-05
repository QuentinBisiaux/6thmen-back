<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* country/index.html.twig */
class __TwigTemplate_69e71615a3c473b75dece64c23d6fd4e extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "country/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "country/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "country/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo "Country index";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    // line 5
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        echo "    <div class=\"flex\">
        <h1 class=\"font-extrabold text-2xl\">Countries</h1>
        <a class=\"ml-auto p-2 bg-indigo-600 text-white rounded-lg border-2\" href=\"";
        // line 8
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_country_new");
        echo "\">Add new</a>
    </div>

    <table class=\"min-w-full text-left\">
        <thead class=\"border-b-2 border-zinc-600\">
            <tr class=\"py-3\">
                <th class=\"font-weight-bold\">Id</th>
                <th class=\"font-weight-bold\">Name</th>
                <th class=\"font-weight-bold\">Alpha2</th>
                <th class=\"font-weight-bold\">Alpha3</th>
                <th class=\"font-weight-bold\">Code</th>
                <th class=\"font-weight-bold\">Region</th>
                <th class=\"font-weight-bold\">CreatedAt</th>
                <th class=\"font-weight-bold\">UpdatedAt</th>
            </tr>
        </thead>
        <tbody>
        ";
        // line 25
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["countries"]) || array_key_exists("countries", $context) ? $context["countries"] : (function () { throw new RuntimeError('Variable "countries" does not exist.', 25, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
            // line 26
            echo "            <tr class=\"border-b-2 border-zinc-200\">
                <td class=\"py-3\">";
            // line 27
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["country"], "id", [], "any", false, false, false, 27), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 28
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 28), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 29
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["country"], "alpha2", [], "any", false, false, false, 29), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 30
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["country"], "alpha3", [], "any", false, false, false, 30), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 31
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["country"], "code", [], "any", false, false, false, 31), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 32
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["country"], "region", [], "any", false, false, false, 32), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 33
            ((twig_get_attribute($this->env, $this->source, $context["country"], "createdAt", [], "any", false, false, false, 33)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["country"], "createdAt", [], "any", false, false, false, 33), "Y-m-d H:i"), "html", null, true))) : (print ("")));
            echo "</td>
                <td class=\"py-3\">";
            // line 34
            ((twig_get_attribute($this->env, $this->source, $context["country"], "updatedAt", [], "any", false, false, false, 34)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["country"], "updatedAt", [], "any", false, false, false, 34), "Y-m-d H:i"), "html", null, true))) : (print ("")));
            echo "</td>
                <td class=\"py-3\">
                    <a class=\"font-bold text-indigo-600\" href=\"";
            // line 36
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_country_edit", ["id" => twig_get_attribute($this->env, $this->source, $context["country"], "id", [], "any", false, false, false, 36)]), "html", null, true);
            echo "\">Edit</a>
                </td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 40
            echo "            <tr>
                <td colspan=\"9\">no records found</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['country'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "        </tbody>
    </table>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    public function getTemplateName()
    {
        return "country/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  171 => 44,  162 => 40,  153 => 36,  148 => 34,  144 => 33,  140 => 32,  136 => 31,  132 => 30,  128 => 29,  124 => 28,  120 => 27,  117 => 26,  112 => 25,  92 => 8,  88 => 6,  78 => 5,  59 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Country index{% endblock %}

{% block body %}
    <div class=\"flex\">
        <h1 class=\"font-extrabold text-2xl\">Countries</h1>
        <a class=\"ml-auto p-2 bg-indigo-600 text-white rounded-lg border-2\" href=\"{{ path('app_country_new') }}\">Add new</a>
    </div>

    <table class=\"min-w-full text-left\">
        <thead class=\"border-b-2 border-zinc-600\">
            <tr class=\"py-3\">
                <th class=\"font-weight-bold\">Id</th>
                <th class=\"font-weight-bold\">Name</th>
                <th class=\"font-weight-bold\">Alpha2</th>
                <th class=\"font-weight-bold\">Alpha3</th>
                <th class=\"font-weight-bold\">Code</th>
                <th class=\"font-weight-bold\">Region</th>
                <th class=\"font-weight-bold\">CreatedAt</th>
                <th class=\"font-weight-bold\">UpdatedAt</th>
            </tr>
        </thead>
        <tbody>
        {% for country in countries %}
            <tr class=\"border-b-2 border-zinc-200\">
                <td class=\"py-3\">{{ country.id }}</td>
                <td class=\"py-3\">{{ country.name }}</td>
                <td class=\"py-3\">{{ country.alpha2 }}</td>
                <td class=\"py-3\">{{ country.alpha3 }}</td>
                <td class=\"py-3\">{{ country.code }}</td>
                <td class=\"py-3\">{{ country.region }}</td>
                <td class=\"py-3\">{{ country.createdAt ? country.createdAt|date('Y-m-d H:i') : '' }}</td>
                <td class=\"py-3\">{{ country.updatedAt ? country.updatedAt|date('Y-m-d H:i') : '' }}</td>
                <td class=\"py-3\">
                    <a class=\"font-bold text-indigo-600\" href=\"{{ path('app_country_edit', {'id': country.id}) }}\">Edit</a>
                </td>
            </tr>
        {% else %}
            <tr>
                <td colspan=\"9\">no records found</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
{% endblock %}
", "country/index.html.twig", "/var/www/templates/country/index.html.twig");
    }
}
