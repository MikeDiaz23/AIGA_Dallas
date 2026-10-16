/**
 * Wrapper for selectbox plugin
 */
jQuery.selectbox_input = function() {

}

jQuery.selectbox_input.onDomReady = function() {
    jQuery.selectbox_input.layout();
};

jQuery.selectbox_input.layout = function() {
    jQuery.selectbox_input.init('.custom-select-input');
}

jQuery.selectbox_input.init = function(selector, options) {

    $(selector).selectbox({
        onOpen : function(inst) {
            var sbSelector = $("#sbSelector_" + inst.uid);
            var sbHolder = sbSelector.closest('.sbHolder');
            var sb = sbHolder.siblings('select');

            sbSelector.addClass('open');
            sbHolder.addClass('open');

            if(options.onOpen) {
                options.onOpen(inst);
            }

        },

        onClose : function(inst) {
            var sbSelector = $("#sbSelector_" + inst.uid);
            var sbHolder = sbSelector.closest('.sbHolder');
            var sb = sbHolder.siblings('select');

            sbSelector.removeClass('open');
            sbHolder.removeClass('open');

            if(options.onClose) {
                options.onClose(inst);
            }

        },

        onChange : function(value, inst, sbSelector) {
            sbSelector.removeClass('unselected');
            if (value == "") {
                sbSelector.addClass('unselected');
            }

            // XXX for whatever reason, the value isn't ready on the change
            // callback in Android, so we set this attribute instead to key off of
            $(inst.input).attr('selected_value', value);

            if(options.onChange) {
                options.onChange(inst, value);
            }

        },

        onLoad : function(inst, input, sbSelector) {
            if ($(input).val() == "") {
                sbSelector.addClass('unselected');
            }

            if(options.onLoad) {
                options.onLoad(inst);
            }

        }
    });
}
