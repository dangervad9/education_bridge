/*-----------------------------
 * Functions
 * - init
 * - reInit
 * - destroy
 * - storageGet
 * - storageSet
 * - UpdateOption
 * - setSettingOption
 * - UpdateOptionFromStorage
 * - CustomEvent for updateOption
 * - CustomEvent for updateOptionFromStorage
 * - setDefault option Soon
 * - addListeners
   * - radioListener
   * - checkboxListener
 * - removeListeners
    * - radioListener
    * - checkboxListener
 * - addClass
 * - removeClass
 * - observeStorage:  https://developer.mozilla.org/en-US/docs/Web/API/Window/storage_event
-----------------------------*/

/*************************
 * Lodash functions use
 * https://lodash.com/docs/4.17.15#functions
 *  function list:
    - _.keys
    - _.has
    - _.findKey
    - _.find
    - _.forEach
    - _.isObject
    - _.isArray
    - _.isString
 * ***********************/

/****** Incomplete Points
 * Color Customizer with color pallet & Custom Color
 * ***/

(function (window) {
    // Listners for Customizer

    const selectors = {
        radio: document.querySelectorAll('[data-setting="radio"]'),
        checkbox: document.querySelectorAll('[data-setting="checkbox"]'),
        attribute: document.querySelectorAll('[data-setting="attribute"]'),
        color: document.querySelectorAll('[data-setting="color"]'),
    };

    /**************************************************************************
     * Default Object for setting Start
     * **********************************************************************/

    const defaults = defaultSetting();

    function defaultSetting() {
        return {
            saveLocal: "cookieStorage", // sessionStorage, localStorage, null
            storeKey: "socialv-setting",
            setting: defaultSettingOption(),
        };
    }

    function defaultSettingOption() {
        return {
            theme_scheme_direction: {
                target: "html",
                choices: ["ltr", "rtl"],
                value: "ltr",
            },
            theme_color: {
                target: "body",
                choices: [
                    "theme-color-blue",
                    "theme-color-gray",
                    "theme-color-red",
                    "theme-color-yellow",
                    "theme-color-pink",
                    "theme-color-default",
                ],
                type: "variable",
                colors: {
                    "--{{prefix}}primary": "#2f65b9",
                },
                value: "theme-color-default",
            },
            header_navbar: {
                target: "#default-header",
                choices: [
                    "default",
                    "header-glass",
                    "header-transparent",
                ],
                value: "default",
            },
            sidebar_color: {
                target: '[data-toggle="main-sidebar"]',
                choices: [
                    "sidebar-white",
                    "sidebar-dark",
                    "sidebar-color",
                    "sidebar-transparent",
                    "sidebar-glass",
                ],
                value: "sidebar-white",
            },
            sidebar_type: {
                target: '[data-toggle="main-sidebar"]',
                choices: ["sidebar-hover", "sidebar-mini", "sidebar-boxed", "sidebar-soft"],
                value: [],
            },
            sidebar_menu_style: {
                target: '[data-toggle="main-sidebar"]',
                choices: [
                    "navs-rounded",
                    "navs-rounded-all",
                    "navs-pill",
                    "navs-pill-all",
                    "left-bordered",
                    "navs-full-width",
                ],
                value: "navs-rounded-all",
            }
        };
    }

    /**************************************************************************
     * Default Object for setting End
     * **********************************************************************/

    // Main function
    this.IQSetting = function (opt) {
        this.options = {};

        this.arg = opt;

        this.extend(defaults);

        if (typeof this.options.saveLocal !== typeof null && this.options.saveLocal !== '') {
            this.getStorageValue(this.options.storeKey);
        }

        this.updateOptionFromStorage();

        this.init();

        this.addListeners();

        return this;
    };

    /**************************************************************************
     * Initialize Functions Start
     * **********************************************************************/

    // extend object function to the IQSetting prototype
    IQSetting.prototype.extend = function (defaults) {
        // Create options by extending defaults with the passed in arugments
        if (this.arg && _.isObject(this.arg)) {
            this.options = IQUtils.mergeDeep(defaults, this.arg);
        } else {
            this.options = defaults;
        }
    };

    // Function call by parameter to the IQSetting prototype
    IQSetting.prototype.fnCall = function (
        key,
        value = this.getSettingKey(key).value
    ) {
        if (_.isString(key)) {
            if (
                this.__proto__.hasOwnProperty(key) &&
                _.isFunction(this.__proto__[key])
            ) {
                this.__proto__[key].call(this, value);
            }
        }
    };

    // Init function to the IQSetting prototype
    IQSetting.prototype.init = function () {
        const keys = _.keys(this.options.setting);
        _.forEach(keys, (key) => {
            this.fnCall(key);
        });

        this.saveOption();
    };

    // reInit function to the IQSetting prototype
    IQSetting.prototype.reInit = function () {
        this.destroy();
        this.extend(defaultSetting());
        this.saveLocal(this.options.saveLocal);
        this.init();
        this.afterUpdate("reinit", this.options);
    };

    // After Update function to the IQSetting Prototype
    IQSetting.prototype.afterUpdate = function (
        key,
        value,
        currentValue = ''
    ) {
        const event = new CustomEvent(key, { detail: { value: value, name: key, currentValue: currentValue } });
        document.dispatchEvent(event);
        this.saveOption();
    };

    // Destroy function to the IQSetting prototype
    IQSetting.prototype.destroy = function () {
        this.removeOption();
        this.removeListeners();
    };

    // addListeners function to the IQSetting prototype
    IQSetting.prototype.addListeners = function (elems, key) {
        this.addRadioListener();
        this.addCheckboxListener();
        this.addAttributeListener();
        this.addColorListner();
    };

    // removeListeners function to the IQSetting prototype
    IQSetting.prototype.removeListeners = function (elems, key) {
        this.removeRadioListeners();
        this.removeCheckboxListeners();
        this.removeAttributeListeners();
    };

    /**************************************************************************
     * Initialize Functions End
     * **********************************************************************/

    /**************************************************************************
     * Get Value Functions Start
     * **********************************************************************/

    // Update option key values to the IQSetting
    IQSetting.prototype.setMainOption = function (key, value) {
        this.options[key] = value;
    };

    // get setting options function to the IQSetting prototype
    IQSetting.prototype.getSettingOptions = function () {
        return this.options.settings;
    };

    // get Setting key function to the IQSetting prototype
    IQSetting.prototype.getSettingKey = function (key) {
        return this.options.setting[key];
    };

    // Update option setting key values to the IQSetting
    IQSetting.prototype.setSettingOption = function (key, value, manual) {
        if (manual) {
            this.options.setting[key].value = value;
        }
    };

    // Update theme color custom choise object to the IQSetting
    this.IQSetting.prototype.setSettingColorChoice = function (key, pair) {
        this.options.setting[key].colors[pair.key] = pair.value;
    };

    // get option json function to the IQSetting prototype
    IQSetting.prototype.getSettingJson = function () {
        const self = this;
        const json = {};
        Object.keys(self.options).forEach(function (key) {
            if (key !== "afterInit" && key !== "beforeInit") {
                json[key] = self.options[key];
                if (key === "setting") {
                    Object.keys(json[key]).forEach(function (subKey) {
                        delete json[key][subKey].target;
                        delete json[key][subKey].type;
                        delete json[key][subKey].choices;
                    });
                }
            }
        });
        this.options = IQUtils.mergeDeep(defaults, json);
        return JSON.stringify(json, null, 4);
    };

    // Static method to get the instance of the IQSetting
    IQSetting.getInstance = function () {
        if (!IQSetting.instance) {
            IQSetting.instance = new IQSetting();
        }
        return IQSetting.instance;
    };

    /**************************************************************************
     * Get Value Functions End
     * **********************************************************************/

    /**************************************************************************
     * Storage get & update Functions Start
     * **********************************************************************/

    // function for save option in localStorage or sessionStorage based on options
    IQSetting.prototype.saveOption = function () {
        const key = this.options.storeKey;
        const value = this.options;
        IQUtils.removeSessionStorage(key);
        IQUtils.removeLocalStorage(key);
        switch (this.options.saveLocal) {
            case "localStorage":
                return IQUtils.saveLocalStorage(key, JSON.stringify(value));
                break;

            case "sessionStorage":
                return IQUtils.saveSessionStorage(key, JSON.stringify(value));
                break;

            case "cookieStorage":
                return IQUtils.setCookie(key, JSON.stringify(value));
                break;

            default:
                break;
        }
    };

    // function for get option in localStorage or sessionStorage based on options
    IQSetting.prototype.getOption = function (storage) {
        const key = this.options.storeKey;
        switch (storage) {
            case "localStorage":
                return IQUtils.getLocalStorage(key);
                break;

            case "sessionStorage":
                return IQUtils.getSessionStorage(key);
                break;

            default:
                break;
        }
    };

    // function for remove option to localStorage or sessionStorage based on options
    IQSetting.prototype.removeOption = function () {
        const key = this.options.storeKey;
        switch (this.options.saveLocal) {
            case "localStorage":
                IQUtils.removeLocalStorage(key);
                break;

            case "sessionStorage":
                IQUtils.removeSessionStorage(key);
                break;

            case "cookieStorag":
                IQUtils.removeCookie(key);
                break;

            default:
                break;
        }
    };

    // function for update option from localStorage or sessionStorage based on options
    IQSetting.prototype.updateOptionFromStorage = function () {
        const key = this.options.storeKey;
        switch (this.options.saveLocal) {
            case "localStorage":
                const localValue = IQUtils.getLocalStorage(key);
                if (localValue) {
                    this.options = JSON.parse(localValue);
                }
                break;

            case "sessionStorage":
                const sessionValue = IQUtils.getSessionStorage(key);
                if (sessionValue) {
                    this.options = JSON.parse(sessionValue);
                }
                break;
            case "cookieStorage":
                const cookieValue = IQUtils.getCookie(key);
                if (cookieValue) {
                    this.options = JSON.parse(cookieValue);
                }
                break;

            default:
                this.removeOption();
                break;
        }
    };

    // function for get storage value if exists
    IQSetting.prototype.getStorageValue = function (key) {
        const checkKey = IQUtils.checkStorageArray(key, [
            "localStorage",
            "sessionStorage",
            "cookieStorage",
        ]);
        if (!checkKey.result) {
            this.options = JSON.parse(this.getOption(checkKey.storage));
            IQUtils.getElems(`input[name="saveLocal"]`).forEach(function (el) {
                el.checked = false;
                if (el.value === checkKey.storage) {
                    el.checked = true;
                }
            });
        }
    };

    /**************************************************************************
     * Storage get & update Functions End
     * **********************************************************************/

    /**************************************************************************
     * Input Update Functions Start
     * **********************************************************************/

    // Input radio input manually change function to the IQSetting prototype
    IQSetting.prototype.__radioInputChange__ = function (key) {
        const obj = this.getSettingKey(key);
        IQUtils.getElems(`input[name="${key}"]`).forEach(function (el) {
            el.checked = false;
            if (el.value === obj.value) {
                el.checked = true;
            }
        });
    };
    // Input checkbox input manually change function to the IQSetting prototype
    IQSetting.prototype.__checkboxInputChange__ = function (key) {
        const obj = this.getSettingKey(key);
        IQUtils.getElems(`input[name="${key}"]`).forEach(function (el) {
            el.checked = false;
            if (obj.value.indexOf(el.value) !== -1) {
                el.checked = true;
            }
        });
    };
    // Input manually change function to the IQSetting prototype
    IQSetting.prototype.__inputChange__ = function (key, value) {
        IQUtils.getElems(`input[name="${key}"]`).forEach(function (el) {
            el.value = value;
        });
    };
    /**************************************************************************
     * Input Update Functions End
     * **********************************************************************/

    /**************************************************************************
     * Dom & Object Update Functions Start
     * IQSetting.options update functions saveLocal, setting:key, value etc...
     * **********************************************************************/

    // radio update function to the IQSetting prototype
    IQSetting.prototype.__radioUpdate__ = function (key, value, cb) {
        const obj = this.getSettingKey(key);
        if (value !== null) {
            obj.value = value;
            this.setSettingOption(key, value);
        }
        if (obj.target !== null) {
            obj.choices.forEach((other) => {
                IQUtils.removeClass(obj.target, other);
            });
            IQUtils.addClass(obj.target, value);
        }
        this.__radioInputChange__(key);
        if (_.isFunction(cb)) {
            cb(key, value, obj);
        }
        this.afterUpdate(key, value);
    };

    // style update function to the IQSetting prototype
    IQSetting.prototype.__styleUpdate__ = function (
        key,
        pair = { prop: "", value: "value" },
        cb
    ) {
        const obj = this.getSettingKey(key);
        if (pair.value !== null) {
            obj.value = pair.value;
            this.setSettingOption(key, pair.value);
        }
        if (obj.target !== null) {
            IQUtils.setStyle(obj.target, pair);
        }
        this.__radioInputChange__(key);
        if (_.isFunction(cb)) {
            cb(key, pair.value);
        }
        this.afterUpdate(key, pair);
    };

    // attribute update function to the IQSetting prototype
    IQSetting.prototype.__attributeUpdate__ = function (
        key,
        pair = { prop: "color", value: "value" },
        cb
    ) {
        const obj = this.getSettingKey(key);
        if (pair.value !== null) {
            obj.value = pair.value;
            this.setSettingOption(key, pair.value);
        }
        if (obj.target !== null) {
            IQUtils.setAttr(obj.target, pair);
        }
        this.__radioInputChange__(key);
        if (_.isFunction(cb)) {
            cb(key, pair.value);
        }
        this.afterUpdate(key, pair);
    };

    // checkbox update function to the IQSetting Prototype
    IQSetting.prototype.__checkboxUpdate__ = function (key, value, currentValue, cb) {
        const obj = this.getSettingKey(key);
        if (value !== null) {
            obj.value = value;
            this.setSettingOption(key, value);
        }
        if (obj.target !== null) {
            obj.choices.forEach((other) => {
                IQUtils.removeClass(obj.target, other);
            });
            if (obj.value.length) {
                obj.value.forEach((objValue) => {
                    IQUtils.addClass(obj.target, objValue);
                });
            }
        }
        this.__checkboxInputChange__(key);
        if (_.isFunction(cb)) {
            cb(key, value);
        }
        this.afterUpdate(key, value, currentValue);
    };


    // Update theme color & custom color to the IQSetting Prototype
    IQSetting.prototype.__updateThemeColor__ = function (key, value) {
        const obj = this.getSettingKey(key);
        if (value !== null) {
            obj.value = value;
            this.setSettingOption(key, value);
        }
        if (obj.target !== null) {
            obj.choices.forEach((other) => {
                IQUtils.removeClass(obj.target, other);
            });
            if (obj.value !== "custom") {
                this.resetColor(key);
            }
            if (!_.isObject(obj.value)) {
                _.forEach(obj.colors, (value, index) => {
                    if (
                        IQUtils.getElem(
                            `[data-extra="${index.replace("--{{prefix}}", "")}"]`
                        ) !== null
                    ) {
                        IQUtils.getElem(
                            `[data-extra="${index.replace("--{{prefix}}", "")}"]`
                        ).value = value;
                    }
                    this.setSettingColorChoice(key, {
                        key: index,
                        value: value,
                    });
                });
                let prefix = IQUtils.getRootVars("--prefix") || "color-theme-";
                let newColors = {};
                const theme_scheme = document.getElementsByTagName("html")[0].getAttribute('data-mode');
                let dark = false
                if (theme_scheme !== 'light' && theme_scheme !== 'system') {
                    dark = true
                }

                _.forEach(obj.colors, (value, key) => {
                    key = key.replace("{{prefix}}", prefix);
                    newColors = {
                        ...newColors,
                        ...IQUtils.getColorShadeTint(key, value, dark),
                    };
                });
                IQUtils.setRootVariables(newColors);
                IQUtils.addClass("body", obj.value);
                switch (obj.type) {
                    case "default":
                        IQUtils.removeClass("body", obj.value);
                        IQUtils.removeRootVariables(newColors);
                        break;
                    default:
                        break;
                }
            }
        }
        this.__radioInputChange__(key);
        this.afterUpdate(key, value);
    };

    this.IQSetting.prototype.resetColor = function (key) {
        const choices = defaults.setting.theme_color.choices.find(
            (x) => x.name == "custom"
        );
        if (choices !== undefined) {
            _.forEach(defaults.setting.theme_color.colors, (value, index) => {
                this.setSettingColorChoice(key, {
                    key: index,
                    value: value,
                });
            });
        }
    };


    // Update option function to the IQSetting Prototype
    IQSetting.prototype.__updateOption__ = function (key, value) {
        this.setMainOption(key, value);
        this.saveOption();
        this.updateOptionFromStorage();
    };

    /**************************************************************************
     * Dom & Object Update Functions End
     * **********************************************************************/

    /**************************************************************************
     * Add Listener Functions Start
     * **********************************************************************/

    // Add radio event listener to the IQSetting prototype
    IQSetting.prototype.addRadioListener = function (cb) {
        const self = this;
        selectors.radio.forEach(function (item) {
            item.addEventListener("change", function (e) {
                const value = e.target.value;
                const key = e.target.getAttribute("name");
                // Update dom values based on radio button
                if (key === "theme_color") {
                    if (e.target.dataset.colors !== null) {
                        const colors = JSON.parse(e.target.dataset.colors);
                        _.forEach(colors, (value, colorKey) => {
                            const newKey = "--{{prefix}}" + colorKey;
                            self.setSettingColorChoice(key, {
                                key: newKey,
                                value: value,
                            });
                        });
                    }
                }
                self.__proto__[key].call(self, value);
                if (_.isFunction(cb)) {
                    cb();
                }
            });
        });
    };

    // Add checkbox event listener to the IQSetting Prototype
    IQSetting.prototype.addCheckboxListener = function (cb) {
        const self = this;

        // add event listener to all setting checkboxes
        selectors.checkbox.forEach(function (item) {
            item.addEventListener("change", (e) => {
                const values = [];
                const key = e.target.getAttribute("name");

                // checkbox values get from domElement
                const checkboxElements = document.querySelectorAll(`[name="${key}"]`);
                checkboxElements.forEach(function (item) {
                    if (item.checked) {
                        values.push(item.value);
                    }
                });

                // Update dom values based on checkbox
                self.__proto__[key].call(self, values, e.target.value);
                if (_.isFunction(cb)) {
                    cb();
                }
            });
        });
    };

    // Add attribute event listener to the IQSetting Prototype
    IQSetting.prototype.addAttributeListener = function (cb) {
        const self = this;
        selectors.attribute.forEach(function (item) {
            // add event listener for attribute change
            item.addEventListener("change", function (e) {
                const value = e.target.value;
                const key = e.target.getAttribute("name");
                const pair = {
                    prop: e.target.getAttribute("data-prop"),
                    value: value,
                };
                // Update dom values based on attribute
                self.__proto__[key].call(self, pair.value);
                if (_.isFunction(cb)) {
                    cb();
                }
            });
        });
    };

    // Add color event listner to the IQSetting Prototype
    IQSetting.prototype.addColorListner = function () {
        const self = this;
        selectors.color.forEach((item) => {
            const debFun = IQUtils.debounce(
                function (name, value) {
                    self.setSettingColorChoice(name, value);
                    self.theme_color("custom");
                },
                200,
                false
            );
            item.addEventListener(
                "input",
                (e) => {
                    const value = {
                        key: `--{{prefix}}${e.target.dataset.extra}`,
                        value: e.target.value,
                    };
                    debFun(e.target.name, value);
                },
                false
            );
        });
    };

    /**************************************************************************
     * Add Listener Functions End
     * **********************************************************************/

    /**************************************************************************
     * Remove Listener Functions Start
     * **********************************************************************/

    // remove radio listeners function to the IQSetting prototype
    IQSetting.prototype.removeRadioListeners = function () {
        selectors.radio.forEach(function (item) {
            item.removeEventListener("change", null);
        });
    };

    // remove checkbox listeners function to the IQSetting prototype
    IQSetting.prototype.removeCheckboxListeners = function () {
        selectors.checkbox.forEach(function (item) {
            item.removeEventListener("change", null);
        });
    };

    // remove attribute listeners function to the IQSetting prototype
    IQSetting.prototype.removeAttributeListeners = function () {
        selectors.attribute.forEach(function (item) {
            item.removeEventListener("change", null);
        });
    };


    /**************************************************************************
     * Remove Listener Functions End
     * **********************************************************************/
    // 1. theme_scheme_direction function to the IQSetting prototype @params: value (string)
    IQSetting.prototype.theme_scheme_direction = function (value) {
        if (typeof value !== typeof null) {
            const __this = this;
            this.__attributeUpdate__(
                "theme_scheme_direction",
                { prop: "dir", value: value },
                function (key, val) {
                    const LangElements = Array.from(document.getElementsByClassName("elementor-section-stretched"));
                    const version = document.querySelector('meta[name="setting_options"]').getAttribute("data-version");
                    const path = document.querySelector('meta[name="setting_options"]').getAttribute("data-path"); 
                    const RTLgetCss = (document.getElementById('bootstrap-css')) ? document.getElementById('bootstrap-css') : null;
                    if (RTLgetCss != null) {
                        const r_url = RTLgetCss.getAttribute('href');
                        if (val == 'rtl') {
                            const rb_url = RTLgetCss.setAttribute('href', (path + 'vendor/bootstrap.rtl.min.css' + '?ver=' + version));
                            RTLgetCss.toString().replace(r_url, rb_url);
                            for (let i = 0; i < LangElements.length; i++) {
                                LangElements[i].style.right = LangElements[i].style.left;
                                LangElements[i].style.left = 'auto';
                            }
                            wpeditorblock();
                        } else {
                            const rb_url = RTLgetCss.setAttribute('href', (path + 'vendor/bootstrap.min.css' + '?ver=' + version));
                            RTLgetCss.toString().replace(r_url, rb_url);
                            for (let i = 0; i < LangElements.length; i++) {
                                LangElements[i].style.left = LangElements[i].style.right;
                                LangElements[i].style.right = 'auto';
                            }
                            jQuery('iframe').contents().find("#tinymce").attr('dir', 'ltr');

                        }
                    }
                    __this.rtlChange(val == "rtl" ? true : false);
                    if (typeof $ !== typeof undefined) {
                        if ($(`[data-select="font"]`).data("select2")) {
                            $(`[data-select="font"]`).select2("destroy").select2();
                        }
                    }
                }
            );
        }
    };

    // 2. theme_color function to the IQSetting prototype @params: value (string)
    IQSetting.prototype.theme_color = function (value) {
        if (typeof value !== typeof null) {
            this.__updateThemeColor__("theme_color", value);
        }
    };

    // 3. header_navbar function to the IQSetting prototype @params: value (string)
    IQSetting.prototype.header_navbar = function (value) {
        if (typeof value !== typeof null) {
            this.__radioUpdate__("header_navbar", value);
        }
    };

    // 4. sidebar_color function to the IQSetting prototype @params: value (string)
    IQSetting.prototype.sidebar_color = function (value) {
        if (typeof value !== typeof null) {
            this.__radioUpdate__("sidebar_color", value);
        }
    };

    // 5. sidebar_type function to the IQSetting prototype @params: value (string)
    IQSetting.prototype.sidebar_type = function (value, currentValue) {
        if (value !== null) {
            if(value.includes("sidebar-hover") && !value.includes("sidebar-mini"))
                value.push("sidebar-mini");

            this.__checkboxUpdate__("sidebar_type", value, currentValue);
        }
    };

    // 6. sidebar_menu_style function to the IQSetting prototype @params: value (string)
    IQSetting.prototype.sidebar_menu_style = function (value) {
        if (typeof value !== typeof null) {
            this.__radioUpdate__("sidebar_menu_style", value);
        }
    };


    // saveLocal function to the IQSetting prototype value (string)
    IQSetting.prototype.saveLocal = function (value = null) {
        if (value !== null) {
            this.__updateOption__("saveLocal", value);
        }
    };
    /**************************************************************************
       * Additional Functions Start
       * **********************************************************************/
    // Rtl Change to Offcanvas left to right Static Function
    IQSetting.prototype.rtlChange = function (check) {
        IQUtils.addClass(".offcanvas-start", "on-rtl", "start");
        IQUtils.addClass(".offcanvas-end", "on-rtl", "end");
        if (check) {
            IQUtils.addClass(".on-rtl.start", "offcanvas-end");
            IQUtils.removeClass(".on-rtl.start", "offcanvas-start");
            IQUtils.addClass(".on-rtl.end", "offcanvas-start");
            IQUtils.removeClass(".on-rtl.end", "offcanvas-end");
        } else {
            IQUtils.addClass(".on-rtl.start", "offcanvas-start");
            IQUtils.removeClass(".on-rtl.start", "offcanvas-end");
            IQUtils.addClass(".on-rtl.end", "offcanvas-end");
            IQUtils.removeClass(".on-rtl.end", "offcanvas-start");
        }
    };
    /**************************************************************************
     * Additional Functions End
     * **********************************************************************/
    // Export the IQSetting
    window.IQSetting = this.IQSetting;

    return window.IQSetting;
})(window);
