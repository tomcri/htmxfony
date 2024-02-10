### Symfony sdk for [htmx](https://htmx.org/)
- [x] Symfony 5.4 or greater
- [x] PHP 7.1 or greater

### Installation

#### Composer

```bash
composer require tomcri/htmxfony
```

#### Configuration

In order to use `HtmxResponse` in Controllers, Listeners, EventSubscribers, etc..., `HtmxKernelTrait` must be included in the Kernel class:

```php
/* src/Kernel.php: */

class Kernel extends BaseKernel
{
    ...
    use HtmxKernelTrait;
    
    ...
}
```

### Usage

#### [Request headers](https://htmx.org/docs/#request-headers)
```php
use HtmxControllerTrait;

public function index(HtmxRequest $request): Response
{
    // indicates that the request is via an element using hx-boost
    $request->isBoosted();
    
    // the current URL of the browser
    $request->getCurrentUrl();
    
    // true if the request is for history restoration after a miss in the local history cache
    $request->isHistoryRestoreRequest();
    
    // the user response to an hx-prompt
    $request->getPromptResponse();
    
    // true if the request is made by Htmx
    $request->isHtmxRequest();
    
    // he id of the target element if it exists
    $request->getTargetId();
    
    // the name of the triggered element if it exists
    $request->getTriggerName();
    
    // the id of the triggered element if it exists
    $request->getTriggerId();
...
```

#### [Response headers](https://htmx.org/docs/#response-headers)
```php
use HtmxControllerTrait;

public function index(HtmxRequest $request): Response
{
    ...

    return $this->htmxRender('homepage/index.html.twig') // or new HtmxResponse()
        // Optional headers:
        ->setLocation(new HtmxLocation( // allows you to do a client-side redirect that does not do a full page reload. (https://htmx.org/headers/hx-location/)
            "/location", // path
            'testsource', // the source element of the request
            null, // an event that “triggered” the request
            null, // a callback that will handle the response HTML
            "#testdiv", // the target to swap the response into
            'outerHTML', // how the response will be swapped in relative to the target
            ['test' => 'test'], // values to submit with the request
            ['X-Test' => 'test'], // headers to submit with the request
        ))
        ->setPushUrl('/push') // pushes a new url into the history stack
        ->setReplaceUrl('/replace') // replaces the current URL in the location bar
        ->setReSwap('outerHTML') // allows you to specify how the response will be swapped. See hx-swap for possible values
        ->setReTarget('#testdiv') // a CSS selector that updates the target of the content update to a different element on the page
        ->setReSelect('#testdiv') // a CSS selector that allows you to choose which part of the response is used to be swapped in. Overrides an existing hx-select on the triggering element
        ->setTriggers( // allows you to trigger client-side events (https://htmx.org/headers/hx-trigger/)
            new HtmxTrigger('trigger1'), // simple trigger
            new HtmxTrigger('trigger2', 'trigger2 message'), // trigger with string value
            new HtmxTrigger('trigger3', [ // trigger with array value
                'prop1' => 'value1',
                'prop2' => 'value2',
            ]),
            new HtmxTrigger('trigger4', $object) // trigger with object value, object must implements JsonSerializable interface
        )
        ->setTriggersAfterSettle() // allows you to trigger client-side events after the settle step
        ->setTriggerAfterSwap() // allows you to trigger client-side events after the swap step
        ;
}
...
```

#### [Render blocks of a template](https://htmx.org/docs/#oob_swaps)

```html
<!-- index.html.twig: -->

{% extends 'layout.html.twig' %}

{% block block1 %}
    <!-- notice the hx-swap-oob="true" flag -->
    <div id="block1" hx-swap-oob="true"> 
        block1 content
    </div>
{% endblock block1 %}

{% block block2 %}
    <div id="block2" hx-swap-oob="true">
        block2 content
    </div>
{% endblock block2 %}
```

```php
use HtmxControllerTrait;

public function index(HtmxRequest $request): Response
{
    return $this->htmxRenderBlock( //render one or more blocks of a template
        new TemplateBlock('homepage/index.html.twig', 'block1', [/*params*/]),
        new TemplateBlock('homepage/other.html.twig', 'block2', [/*params*/]),
    );
}
...
```
#### Refresh

```php
use HtmxControllerTrait;

public function index(HtmxRequest $request): Response
{
    return $this->htmxRefresh();
}
...
```
    
#### Redirect
```php
use HtmxControllerTrait;

public function index(HtmxRequest $request): Response
{
    return $this->htmxRedirect('https://htmx.org/');
}
...
```

#### Stop [polling](https://htmx.org/docs/#polling)
```html
<!-- index.html.twig: -->

{% extends 'layout.html.twig' %}

{% block body %}
    <script>
        window.pollingIndex = 0;
        document.body.addEventListener("polling", function(evt){
            window.pollingIndex++;
            console.log("polling: " + pollingI);
        });
    </script>
    <div hx-get="/polling" hx-vars='{"i": window.pollingIndex}' hx-trigger="every 2s"></div>
{% endblock body %}
```

```php
use HtmxControllerTrait;

public function polling(HtmxRequest $request): Response
{
    if ((int)$request->get('i', 0) >= 2) {
        return new HtmxStopPollingResponse();
    }

    return (new HtmxResponse())->setTriggers(
        new HtmxTrigger('polling')
    );
}
...
```

### Tests

```bash
composer test
```

### Coding Standards

```bash
composer cs:check
composer cs:fix
```
