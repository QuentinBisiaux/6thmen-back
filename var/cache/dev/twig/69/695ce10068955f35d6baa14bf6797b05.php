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

/* league/index.html.twig */
class __TwigTemplate_2fb5b7484eff7207bcd5685ff0361ec2 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "league/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "league/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "league/index.html.twig", 1);
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

        echo "League index";
        
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
        <h1 class=\"font-extrabold text-2xl\">Leagues</h1>
        <a class=\"ml-auto p-2 bg-indigo-600 text-white rounded-lg border-2\" href=\"";
        // line 8
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_league_new");
        echo "\">Add new</a>
    </div>

    <table class=\"min-w-full text-left\">
        <thead class=\"border-b-2 border-zinc-600\">
            <tr class=\"py-3\">
                <th class=\"font-weight-bold py-3\">Id</th>
                <th class=\"font-weight-bold\">Name</th>
                <th class=\"font-weight-bold\">CreatedAt</th>
                <th class=\"font-weight-bold\">UpdatedAt</th>
                <th class=\"font-weight-bold\">actions</th>
            </tr>
        </thead>
        <tbody>
        ";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["leagues"]) || array_key_exists("leagues", $context) ? $context["leagues"] : (function () { throw new RuntimeError('Variable "leagues" does not exist.', 22, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["league"]) {
            // line 23
            echo "            <tr class=\"border-b-2 border-zinc-200\">
                <td class=\"py-3\">";
            // line 24
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["league"], "id", [], "any", false, false, false, 24), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 25
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["league"], "name", [], "any", false, false, false, 25), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 26
            ((twig_get_attribute($this->env, $this->source, $context["league"], "createdAt", [], "any", false, false, false, 26)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["league"], "createdAt", [], "any", false, false, false, 26), "Y-m-d H:i"), "html", null, true))) : (print ("")));
            echo "</td>
                <td class=\"py-3\">";
            // line 27
            ((twig_get_attribute($this->env, $this->source, $context["league"], "updatedAt", [], "any", false, false, false, 27)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["league"], "updatedAt", [], "any", false, false, false, 27), "Y-m-d H:i"), "html", null, true))) : (print ("")));
            echo "</td>
                <td class=\"py-3\">
                    <a class=\"font-bold text-indigo-600\" href=\"";
            // line 29
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_league_edit", ["id" => twig_get_attribute($this->env, $this->source, $context["league"], "id", [], "any", false, false, false, 29)]), "html", null, true);
            echo "\">Edit</a>
                </td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 33
            echo "            <tr>
                <td colspan=\"5\">no records found</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['league'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 37
        echo "        </tbody>
    </table>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    public function getTemplateName()
    {
        return "league/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  152 => 37,  143 => 33,  134 => 29,  129 => 27,  125 => 26,  121 => 25,  117 => 24,  114 => 23,  109 => 22,  92 => 8,  88 => 6,  78 => 5,  59 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}League index{% endblock %}

{% block body %}
    <div class=\"flex\">
        <h1 class=\"font-extrabold text-2xl\">Leagues</h1>
        <a class=\"ml-auto p-2 bg-indigo-600 text-white rounded-lg border-2\" href=\"{{ path('app_league_new') }}\">Add new</a>
    </div>

    <table class=\"min-w-full text-left\">
        <thead class=\"border-b-2 border-zinc-600\">
            <tr class=\"py-3\">
                <th class=\"font-weight-bold py-3\">Id</th>
                <th class=\"font-weight-bold\">Name</th>
                <th class=\"font-weight-bold\">CreatedAt</th>
                <th class=\"font-weight-bold\">UpdatedAt</th>
                <th class=\"font-weight-bold\">actions</th>
            </tr>
        </thead>
        <tbody>
        {% for league in leagues %}
            <tr class=\"border-b-2 border-zinc-200\">
                <td class=\"py-3\">{{ league.id }}</td>
                <td class=\"py-3\">{{ league.name }}</td>
                <td class=\"py-3\">{{ league.createdAt ? league.createdAt|date('Y-m-d H:i') : '' }}</td>
                <td class=\"py-3\">{{ league.updatedAt ? league.updatedAt|date('Y-m-d H:i') : '' }}</td>
                <td class=\"py-3\">
                    <a class=\"font-bold text-indigo-600\" href=\"{{ path('app_league_edit', {'id': league.id}) }}\">Edit</a>
                </td>
            </tr>
        {% else %}
            <tr>
                <td colspan=\"5\">no records found</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
{% endblock %}
", "league/index.html.twig", "/var/www/templates/league/index.html.twig");
    }
}
