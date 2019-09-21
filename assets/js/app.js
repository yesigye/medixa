(function() {
    document.addEventListener('DOMContentLoaded', function(e) {
        // Toggling side bar
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        // Launch BS modal via attribute
       var triggerModal = $('[data-trigger-modal]').attr('data-trigger-modal');
       if (triggerModal) $(triggerModal).modal('show');
        
        // Tooltips
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
        
        // BS tab redirects
       $('body a[data-toggle="tab"]').on('click', function (e) {
            // update url hash for redirect
            document.location.hash = $(this).attr('href');
        })
        var uriHash = $(location).prop('hash');
        if (uriHash.startsWith("#tab-")) {
            $('body a[href="' + uriHash + '"]').tab('show');
        }

        // All input elements
        var inputElements = document.querySelectorAll('validate input:not(button)');

        // Create a container for validation rule names.
        var ruleNames = [];
        var forEach = Array.prototype.forEach;
        
        // Fills array with rule names.
        // Looks for all elements with the data-rule
        // attribute and then adds the rule
        // name to the array.
        var ruleElements = document.querySelectorAll('[data-rule]');
        forEach.call(ruleElements, function(element) {
            var ruleName = element.getAttribute('data-rule');
            if (ruleNames.indexOf(ruleNames) < 0) {
                ruleNames.push(ruleName);
            }
        });
        
        // First clear the UI by hiding all 
        // validation messages. Then run 
        // validation rules on the selected form.
        var validate = function(e) {

            var element = e.currentTarget;

            var messages = document.querySelectorAll('.invalid-feedback [data-rule]');
            forEach.call(messages, function(message) {
                message.classList.add('d-none');
            });
            var valid = document.querySelector('form').checkValidity();

            if(element.type == 'submit') {
                forEach.call(inputElements, function(e) { e.focus(); e.blur(); });
            }
            if(element.validity.valid) {
                element.classList.remove('is-invalid');
                element.classList.add('is-valid');
            } else {
                element.classList.remove('is-valid');
                element.classList.add('is-invalid');
            }
        };
        
        // Check each input element to determine 
        // which element is invalid. Once an 
        // invalid state is detected, then loop 
        // through the validation rules to find 
        // out which is broken and therefore 
        // which message to display to the user.
        var validationFail = function (e) {

            var element, validity;

            element = e.currentTarget;
            validity = element.validity;
            
            if (!validity.valid) {
                ruleNames.forEach(function (ruleName) {
                    checkRule(validity, ruleName, element);
                });
                e.preventDefault();
            }
        };
        
        // Uses the instance of the input element's 
        // ValidityState object to run a validation 
        // rule. If the validation rule returns 
        // 'true' then the rule is broken and 
        // the appropriate validation message 
        //is exposed to the user. 
        var checkRule = function(state, ruleName, element) {
            if (state[ruleName]) {
            
                var rules = element
                                    .nextElementSibling
                                    .querySelectorAll('[data-rule="' + ruleName + '"]');
                
                forEach.call(rules, function(rule){
                    rule.classList.remove('d-none');
                });
            }
        };
        
        // Attaches validation event handlers to all input elements that are NOT buttons.
        forEach.call(inputElements, function(input) {
            input.oninvalid = validationFail;
            input.onblur = validate;
        });
        
        const submitBtn = document.querySelector('validate [type="submit"]');

        if(submitBtn)
            document.querySelector('validate [type="submit"]').addEventListener('click', validate, false);
    }, false);

    // Affix
    const affixEl = $('[data-toggle="affix"]');
    if (affixEl.length) affixEl.affix({ offset:{top: affixEl.height()} });
})();

function tmplAlert(msg = '', type = 'success') {
    return `
        <div class="alert alert-`+type+`">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            `+msg+`
        </div>
    `;
}