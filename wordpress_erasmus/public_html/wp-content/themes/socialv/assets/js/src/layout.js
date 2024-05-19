/*----------------------------------------------
Index Of Script
------------------------------------------------

:: Add Custom CSS
:: Dark - Light Mode
:: Language Swith Mode
:: Reset Settings
:: Copy Json

------------------------------------------------
Index Of Script
----------------------------------------------*/
"use strict";
let setting_options = document.querySelector('meta[name="setting_options"]');
if (setting_options !== null && setting_options !== undefined) {
    setting_options = JSON.parse(setting_options.getAttribute("content"));
} else {
    setting_options = JSON.parse("{}");
}

const setting = (window.IQSetting = new IQSetting(setting_options));

/*---------------------------------------------------------------------
            Dark - Light Mode
-----------------------------------------------------------------------*/

const mode = (document.querySelector('.switch-mode-icon')) ? document.querySelector('.switch-mode-icon') : null;
if (mode != null) {
    var bgClass = window.IQUtils.getCookie('data-mode');
    if (bgClass != '') {
        document.getElementsByTagName("html")[0].setAttribute('data-mode', bgClass);
        document.querySelector('.socialv-switch-mode').setAttribute('data-mode', bgClass);
    } else {
        window.IQUtils.setCookie('data-mode', bgClass);
    }

    const modeSetting = document.querySelector('.socialv-switch-mode');
    if (modeSetting !== null) {
        modeSetting.addEventListener('click', (e) => {
            e.preventDefault();
            var bgClass = modeSetting.getAttribute('data-mode');
            if (bgClass == "dark") {
                bgClass = "light";
            } else {
                bgClass = "dark";
            }
            modeSetting.setAttribute('data-mode', bgClass);
            document.getElementsByTagName("html")[0].setAttribute('data-mode', bgClass);
            window.IQUtils.setCookie('data-mode', bgClass);
            if (typeof window.IQSetting.__updateThemeColor__ === 'function') {
                window.IQSetting.__updateThemeColor__('theme_color', null)
            }
        })
    }
}
/*---------------------------------------------------------------------
            Language Swith Mode
-----------------------------------------------------------------------*/
const LangMode = document.getElementsByTagName("html")[0].getAttribute('dir');
const LangElements = Array.from(document.getElementsByClassName("elementor-section-stretched"));

function LangLoad() {
    if (LangMode == 'rtl') {
        for (let i = 0; i < LangElements.length; i++) {
            LangElements[i].style.right = LangElements[i].style.left;
            LangElements[i].style.left = 'auto';
        }
        wpeditorblock();
    }
}
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(LangLoad, 500);
});


/*---------------------------------------------------------------------
            Reset Settings
-----------------------------------------------------------------------*/
const resetSettings = document.querySelector('[data-reset="settings"]');
if (resetSettings !== null) {
    resetSettings.addEventListener('click', (e) => {
        e.preventDefault();
        const confirm = window.confirm(socialv_global_script.reset_setting);
        if (confirm) {
            window.IQSetting.reInit()
        }
    })
}
/*---------------------------------------------------------------------
            Copy Json
-----------------------------------------------------------------------*/
const copySettings = document.querySelector('[data-copy="settings"]');
if (copySettings !== null) {
    copySettings.addEventListener('click', (e) => {
        e.preventDefault();
        let settingJson = window.IQSetting.getSettingJson()
        const elem = document.createElement("textarea");
        document.querySelector("body").appendChild(elem);
        document.querySelector('.setting_options').setAttribute('value', (settingJson));
        copySettings.setAttribute('data-bs-original-title', 'Copied!');
        document.getElementById("save_layout_setting").submit();
    })
}


function wpeditorblock() {
    jQuery('iframe').contents().find("#tinymce").attr('dir', 'rtl');
    jQuery(document.body).on('woosq_loaded', function (event) {
        jQuery('.thumbnails').attr('dir', 'ltr');
    });
}