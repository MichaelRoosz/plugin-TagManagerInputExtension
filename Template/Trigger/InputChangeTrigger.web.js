(function () {
    return function (parameters, TagManager) {

        var selectors = getSelectors();

        this.setUp = function (triggerEvent) {
            TagManager.dom.onReady(function () {
                if (selectors) {
                    TagManager.dom.bySelector(selectors).forEach(function (element) {
                        var inputTimer = null;
                        var inputWasTriggered = false;

                        TagManager.dom.addEventListener(element, 'input', function (event) {
                            inputWasTriggered = true;

                            if (inputTimer) {
                                clearTimeout(inputTimer);
                            }

                            inputTimer = setTimeout(function () {
                                changeCallback(event, triggerEvent, element);
                                inputTimer = null;
                            }, 1000);
                        }, true);

                        TagManager.dom.addEventListener(element, 'change', function (event) {
                            if (!inputWasTriggered) {
                                changeCallback(event, triggerEvent, element);
                            }
                        }, true);
                    });
                }
            });
        };

        function changeCallback(event, triggerEvent, element) {
            if (!event.target) {
                return;
            }

            var target = event.target;
            if (target.shadowRoot) {
                var composedPath = event.composedPath();
                if (composedPath.length) {
                      target = composedPath[0];   //In shadow DOM select the first event path as the target
                }
            }

            var inputValue = target.value;
            var type = TagManager.dom.getElementAttribute(element, 'type');
            if (type && type.toLowerCase() === 'password') {
                // we do not let users read a value of a password form field
                inputValue = '';
            }

            triggerEvent({
                event: 'TagManagerInputExtension.InputChange',
                'TagManagerInputExtension.InputChangeElement': target,
                'TagManagerInputExtension.InputChangeValue': inputValue,
                'TagManagerInputExtension.InputChangeElementId': TagManager.dom.getElementAttribute(target, 'id'),
                'TagManagerInputExtension.InputChangeElementClasses': TagManager.dom.getElementClassNames(target),
                'TagManagerInputExtension.InputChangeNodeName': target.nodeName,
            });
        }

        function getSelectors() {
            var selectionMethod = parameters.get('selectionMethod');
            if (selectionMethod === 'elementId') {
                return '#' + parameters.get('elementId');
            } else if (selectionMethod === 'cssSelector') {
                return parameters.get('cssSelector');
            }

            return;
        }
    };
})();
