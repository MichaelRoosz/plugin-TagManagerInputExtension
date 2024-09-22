(function () {
    return function (parameters, TagManager) {
        this.get = function () {
            var selectionMethod = parameters.get('selectionMethod');

            if (!selectionMethod) {
                return;
            }

            var dom = TagManager.dom;

            var ele;
            if (selectionMethod === 'elementId') {
                ele = dom.byId(parameters.get('elementId'));
            } else if (selectionMethod === 'cssSelector') {
                ele = dom.bySelector(parameters.get('cssSelector'));
                if (ele && ele[0]) {
                    ele = ele[0];
                } else {
                    ele = null;
                }
            }

            if (ele) {
                var type = dom.getElementAttribute(ele, 'type');
                if (type && type.toLowerCase() === 'password') {
                    // we do not let users read a value of a password form field
                    return;
                }

                return ele.value;
            }

        };
    };
})();