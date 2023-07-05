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

/* standing/_form.html.twig */
class __TwigTemplate_c4d4a3c43ef727adbbc11198ce9cfb7a extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "standing/_form.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "standing/_form.html.twig"));

        // line 1
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 1, $this->source); })()), 'form_start');
        echo "
<div class=\"grid sm:grid-cols-6 gap-x-6 items-center\">
    <div class=\"sm:col-span-1\">
        ";
        // line 4
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 4, $this->source); })()), "league", [], "any", false, false, false, 4), 'label', ["label_attr" => ["class" => "block text-sm font-medium leading-6 text-gray-900"]]);
        // line 6
        echo "
        <div class=\"mt-1\">
            ";
        // line 8
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 8, $this->source); })()), "league", [], "any", false, false, false, 8), 'widget', ["attr" => ["class" => "block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"]]);
        // line 10
        echo "
        </div>
    </div>
    <div class=\"sm:col-span-1\">
        ";
        // line 14
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 14, $this->source); })()), "season", [], "any", false, false, false, 14), 'label', ["label_attr" => ["class" => "block text-sm font-medium leading-6 text-gray-900"]]);
        // line 16
        echo "
        <div class=\"mt-1\">
            ";
        // line 18
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 18, $this->source); })()), "season", [], "any", false, false, false, 18), 'widget', ["attr" => ["class" => "block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"]]);
        // line 20
        echo "
        </div>
    </div>
    <div class=\"sm:col-span-1\">
        ";
        // line 24
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 24, $this->source); })()), "team", [], "any", false, false, false, 24), 'label', ["label_attr" => ["class" => "block text-sm font-medium leading-6 text-gray-900"]]);
        // line 26
        echo "
        <div class=\"mt-1\">
            ";
        // line 28
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 28, $this->source); })()), "team", [], "any", false, false, false, 28), 'widget', ["attr" => ["class" => "block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"]]);
        // line 30
        echo "
        </div>
    </div>
    <div class=\"sm:col-span-1\">
        ";
        // line 34
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 34, $this->source); })()), "victory", [], "any", false, false, false, 34), 'label', ["label_attr" => ["class" => "block text-sm font-medium leading-6 text-gray-900"]]);
        // line 36
        echo "
        <div class=\"mt-1\">
            ";
        // line 38
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 38, $this->source); })()), "victory", [], "any", false, false, false, 38), 'widget', ["attr" => ["class" => "block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"]]);
        // line 40
        echo "
        </div>
    </div>
    <div class=\"sm:col-span-1\">
        ";
        // line 44
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 44, $this->source); })()), "rank", [], "any", false, false, false, 44), 'label', ["label_attr" => ["class" => "block text-sm font-medium leading-6 text-gray-900"]]);
        // line 46
        echo "
        <div class=\"mt-1\">
            ";
        // line 48
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 48, $this->source); })()), "rank", [], "any", false, false, false, 48), 'widget', ["attr" => ["class" => "block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"]]);
        // line 50
        echo "
        </div>
    </div>
    <div class=\"sm:col-span-1\">
        ";
        // line 54
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 54, $this->source); })()), "loses", [], "any", false, false, false, 54), 'label', ["label_attr" => ["class" => "block text-sm font-medium leading-6 text-gray-900"]]);
        // line 56
        echo "
        <div class=\"mt-1\">
            ";
        // line 58
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 58, $this->source); })()), "loses", [], "any", false, false, false, 58), 'widget', ["attr" => ["class" => "block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"]]);
        // line 60
        echo "
        </div>
    </div>
    <div class=\"sm:col-span-1\">
        <button class=\"rounded-md bg-indigo-600 mt-5 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600\">
            ";
        // line 65
        echo twig_escape_filter($this->env, ((array_key_exists("button_label", $context)) ? (_twig_default_filter((isset($context["button_label"]) || array_key_exists("button_label", $context) ? $context["button_label"] : (function () { throw new RuntimeError('Variable "button_label" does not exist.', 65, $this->source); })()), "Save")) : ("Save")), "html", null, true);
        echo "
        </button>
    </div>
</div>
";
        // line 69
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 69, $this->source); })()), 'form_end');
        echo "
";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    public function getTemplateName()
    {
        return "standing/_form.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  141 => 69,  134 => 65,  127 => 60,  125 => 58,  121 => 56,  119 => 54,  113 => 50,  111 => 48,  107 => 46,  105 => 44,  99 => 40,  97 => 38,  93 => 36,  91 => 34,  85 => 30,  83 => 28,  79 => 26,  77 => 24,  71 => 20,  69 => 18,  65 => 16,  63 => 14,  57 => 10,  55 => 8,  51 => 6,  49 => 4,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{{ form_start(form) }}
<div class=\"grid sm:grid-cols-6 gap-x-6 items-center\">
    <div class=\"sm:col-span-1\">
        {{ form_label(form.league, null, {
            'label_attr': {'class': 'block text-sm font-medium leading-6 text-gray-900'}
        }) }}
        <div class=\"mt-1\">
            {{ form_widget(form.league, {
                'attr': {'class': 'block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'}
            }) }}
        </div>
    </div>
    <div class=\"sm:col-span-1\">
        {{ form_label(form.season, null, {
            'label_attr': {'class': 'block text-sm font-medium leading-6 text-gray-900'}
        }) }}
        <div class=\"mt-1\">
            {{ form_widget(form.season, {
                'attr': {'class': 'block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'}
            }) }}
        </div>
    </div>
    <div class=\"sm:col-span-1\">
        {{ form_label(form.team, null, {
            'label_attr': {'class': 'block text-sm font-medium leading-6 text-gray-900'}
        }) }}
        <div class=\"mt-1\">
            {{ form_widget(form.team, {
                'attr': {'class': 'block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'}
            }) }}
        </div>
    </div>
    <div class=\"sm:col-span-1\">
        {{ form_label(form.victory, null, {
            'label_attr': {'class': 'block text-sm font-medium leading-6 text-gray-900'}
        }) }}
        <div class=\"mt-1\">
            {{ form_widget(form.victory, {
                'attr': {'class': 'block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'}
            }) }}
        </div>
    </div>
    <div class=\"sm:col-span-1\">
        {{ form_label(form.rank, null, {
            'label_attr': {'class': 'block text-sm font-medium leading-6 text-gray-900'}
        }) }}
        <div class=\"mt-1\">
            {{ form_widget(form.rank, {
                'attr': {'class': 'block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'}
            }) }}
        </div>
    </div>
    <div class=\"sm:col-span-1\">
        {{ form_label(form.loses, null, {
            'label_attr': {'class': 'block text-sm font-medium leading-6 text-gray-900'}
        }) }}
        <div class=\"mt-1\">
            {{ form_widget(form.loses, {
                'attr': {'class': 'block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'}
            }) }}
        </div>
    </div>
    <div class=\"sm:col-span-1\">
        <button class=\"rounded-md bg-indigo-600 mt-5 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600\">
            {{ button_label|default('Save') }}
        </button>
    </div>
</div>
{{ form_end(form) }}
", "standing/_form.html.twig", "/var/www/templates/standing/_form.html.twig");
    }
}
