<?php

/**
 * Template part for displaying the frontend customizer info
 *
 * @package socialv
 */

namespace SocialV\Utility;
?>

<!-- customizer button -->
<a class="btn-fixed-end socialv-btn-danger btn-icon-box btn-setting" id="settingbutton" data-bs-toggle="offcanvas" data-bs-target="#live-customizer" role="button" aria-controls="live-customizer">
    <i class="iconly-Setting icli"></i>
</a>

<!-- customizer code -->
<div class="offcanvas offcanvas-end live-customizer" tabindex="-1" id="live-customizer" data-bs-scroll="true" data-bs-backdrop="false" aria-labelledby="live-customizer-label">

    <div class="offcanvas-header">
        <div class="d-flex align-items-center">
            <h5 class="offcanvas-title m-0" id="live-customizer-label"><?php esc_html_e("Live Style Customizer", "socialv"); ?></h5>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <?php if (current_user_can('administrator')) { ?>
                <form id="save_layout_setting" method="post" action="">
                    <input type="hidden" id="setting_options" class="socialv-btn-primary px-3 setting_options" name="setting_options" value="" />
                    <button name="submit_btn" class="socialv-btn-primary px-3 border-0" data-copy="settings">
                        <svg style="enable-background:new 0 0 30 30;" version="1.1" viewBox="0 0 30 30" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M22,4h-2v6c0,0.552-0.448,1-1,1h-9c-0.552,0-1-0.448-1-1V4H6C4.895,4,4,4.895,4,6v18c0,1.105,0.895,2,2,2h18  c1.105,0,2-0.895,2-2V8L22,4z M22,24H8v-6c0-1.105,0.895-2,2-2h10c1.105,0,2,0.895,2,2V24z" fill="currentColor" />
                            <rect height="5" width="2" x="16" y="4" />
                        </svg>
                        <?php esc_html_e("Save", "socialv"); ?>
                    </button>
                </form>
            <?php } ?>
            <button class="socialv-btn-primary btn-icon-box border-0 p-0" data-reset="settings">
                <span class="btn-inner">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g opacity="0.4">
                            <path d="M4.88076 14.6713C4.74978 14.2784 4.32504 14.066 3.93208 14.197C3.53912 14.328 3.32675 14.7527 3.45774 15.1457L4.88076 14.6713ZM20.8808 15.1457C21.0117 14.7527 20.7994 14.328 20.4064 14.197C20.0135 14.066 19.5887 14.2784 19.4577 14.6713L20.8808 15.1457ZM4.16925 14.9085C3.45774 15.1457 3.45785 15.146 3.45797 15.1464C3.45802 15.1465 3.45815 15.1469 3.45825 15.1472C3.45845 15.1478 3.45868 15.1485 3.45895 15.1493C3.45948 15.1509 3.46013 15.1528 3.46092 15.1551C3.46249 15.1597 3.46456 15.1657 3.46716 15.1731C3.47235 15.188 3.47961 15.2084 3.48902 15.2341C3.50782 15.2854 3.53521 15.3576 3.5717 15.4477C3.64461 15.6279 3.7542 15.8805 3.90468 16.1814C4.2048 16.7817 4.67223 17.5836 5.34308 18.3886C6.68942 20.0043 8.88343 21.6585 12.1693 21.6585V20.1585C9.45507 20.1585 7.64908 18.8128 6.49542 17.4284C5.91627 16.7334 5.5087 16.0354 5.24632 15.5106C5.11555 15.2491 5.02201 15.0329 4.96212 14.8849C4.9322 14.811 4.91076 14.7543 4.89733 14.7177C4.89062 14.6994 4.88593 14.6861 4.88318 14.6783C4.88181 14.6744 4.88093 14.6718 4.88053 14.6706C4.88033 14.67 4.88025 14.6698 4.88029 14.6699C4.88031 14.67 4.88036 14.6701 4.88044 14.6704C4.88047 14.6705 4.88056 14.6707 4.88058 14.6708C4.88067 14.671 4.88076 14.6713 4.16925 14.9085ZM12.1693 21.6585C15.4551 21.6585 17.6491 20.0043 18.9954 18.3886C19.6663 17.5836 20.1337 16.7817 20.4338 16.1814C20.5843 15.8805 20.6939 15.6279 20.7668 15.4477C20.8033 15.3576 20.8307 15.2854 20.8495 15.2341C20.8589 15.2084 20.8662 15.188 20.8713 15.1731C20.8739 15.1657 20.876 15.1597 20.8776 15.1551C20.8784 15.1528 20.879 15.1509 20.8796 15.1493C20.8798 15.1485 20.8801 15.1478 20.8803 15.1472C20.8804 15.1469 20.8805 15.1465 20.8805 15.1464C20.8807 15.146 20.8808 15.1457 20.1693 14.9085C19.4577 14.6713 19.4578 14.671 19.4579 14.6708C19.4579 14.6707 19.458 14.6705 19.4581 14.6704C19.4581 14.6701 19.4582 14.67 19.4582 14.6699C19.4583 14.6698 19.4582 14.67 19.458 14.6706C19.4576 14.6718 19.4567 14.6744 19.4553 14.6783C19.4526 14.6861 19.4479 14.6994 19.4412 14.7177C19.4277 14.7543 19.4063 14.811 19.3764 14.8849C19.3165 15.0329 19.223 15.2491 19.0922 15.5106C18.8298 16.0354 18.4222 16.7334 17.8431 17.4284C16.6894 18.8128 14.8834 20.1585 12.1693 20.1585V21.6585Z" fill="currentColor"></path>
                            <path d="M21.5183 19.2271C21.4293 19.2234 21.3427 19.196 21.2671 19.1465L16.3546 15.8924C16.2197 15.8026 16.1413 15.6537 16.148 15.4969C16.1546 15.34 16.2452 15.1982 16.3873 15.1202L21.5571 12.2926C21.7075 12.2106 21.8932 12.213 22.0416 12.3003C22.1907 12.387 22.2783 12.5436 22.2712 12.7096L22.014 18.7913C22.007 18.9573 21.9065 19.1059 21.7506 19.1797C21.6772 19.215 21.597 19.2305 21.5183 19.2271" fill="currentColor"></path>
                        </g>
                        <path d="M20.0742 10.0265C20.1886 10.4246 20.6041 10.6546 21.0022 10.5401C21.4003 10.4257 21.6302 10.0102 21.5158 9.61214L20.0742 10.0265ZM4.10803 8.88317C3.96071 9.27031 4.15513 9.70356 4.54226 9.85087C4.92939 9.99818 5.36265 9.80377 5.50996 9.41664L4.10803 8.88317ZM20.795 9.81934C21.5158 9.61214 21.5157 9.6118 21.5156 9.61144C21.5155 9.61129 21.5154 9.6109 21.5153 9.61059C21.5152 9.60998 21.515 9.60928 21.5147 9.60848C21.5143 9.60689 21.5137 9.60493 21.513 9.6026C21.5116 9.59795 21.5098 9.59184 21.5075 9.58431C21.503 9.56925 21.4966 9.54853 21.4882 9.52251C21.4716 9.47048 21.4473 9.39719 21.4146 9.3056C21.3493 9.12256 21.2503 8.8656 21.1126 8.55861C20.8378 7.94634 20.4044 7.12552 19.7678 6.29313C18.4902 4.62261 16.3673 2.87801 13.0844 2.74053L13.0216 4.23922C15.7334 4.35278 17.4816 5.77291 18.5763 7.20436C19.1258 7.92295 19.5038 8.63743 19.744 9.17271C19.8638 9.43949 19.9482 9.65937 20.0018 9.80972C20.0286 9.88483 20.0477 9.94238 20.0596 9.97951C20.0655 9.99808 20.0696 10.0115 20.072 10.0195C20.0732 10.0235 20.074 10.0261 20.0744 10.0273C20.0746 10.0278 20.0746 10.0281 20.0746 10.028C20.0746 10.0279 20.0745 10.0278 20.0745 10.0275C20.0744 10.0274 20.0744 10.0272 20.0743 10.0271C20.0743 10.0268 20.0742 10.0265 20.795 9.81934ZM13.0844 2.74053C9.80146 2.60306 7.54016 4.16407 6.12741 5.72193C5.42345 6.49818 4.92288 7.27989 4.59791 7.86704C4.43497 8.16144 4.31491 8.40923 4.23452 8.58617C4.1943 8.67471 4.16391 8.7457 4.14298 8.79616C4.13251 8.82139 4.1244 8.84151 4.11859 8.85613C4.11568 8.86344 4.11336 8.86938 4.1116 8.8739C4.11072 8.87616 4.10998 8.87807 4.10939 8.87962C4.10909 8.88039 4.10883 8.88108 4.1086 8.88167C4.10849 8.88196 4.10834 8.88234 4.10829 8.88249C4.10815 8.88284 4.10803 8.88317 4.80899 9.14991C5.50996 9.41664 5.50985 9.41692 5.50975 9.41719C5.50973 9.41725 5.50964 9.41749 5.50959 9.4176C5.5095 9.41784 5.50945 9.41798 5.50942 9.41804C5.50938 9.41816 5.50947 9.41792 5.50969 9.41734C5.51014 9.41619 5.51113 9.41365 5.51267 9.40979C5.51574 9.40206 5.52099 9.38901 5.52846 9.37101C5.5434 9.335 5.56719 9.27924 5.60018 9.20664C5.66621 9.0613 5.76871 8.84925 5.91031 8.59341C6.19442 8.08008 6.63084 7.39971 7.23855 6.72958C8.44912 5.39466 10.3098 4.12566 13.0216 4.23922L13.0844 2.74053Z" fill="currentColor"></path>
                        <path d="M8.78337 9.33604C8.72981 9.40713 8.65805 9.46292 8.57443 9.49703L3.1072 11.6951C2.95672 11.7552 2.78966 11.7352 2.66427 11.6407C2.53887 11.5462 2.47359 11.3912 2.48993 11.2299L3.09576 5.36863C3.11367 5.19823 3.22102 5.04666 3.37711 4.97402C3.5331 4.9005 3.71173 4.91728 3.84442 5.01726L8.70581 8.68052C8.8385 8.78051 8.90387 8.94759 8.8762 9.1178C8.86358 9.19825 8.83082 9.27308 8.78337 9.33604" fill="currentColor"></path>
                    </svg>
                </span>
            </button>
            <button type="button" class="btn-close px-0 shadow-none ms-2" data-bs-dismiss="offcanvas" aria-label="Close"><i class="icon-close-2"></i></button>
        </div>
    </div>
    <hr class="hr-horizontal">
    <div class="offcanvas-body data-scrollbar">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <h6 class="mt-4 mb-3"><?php esc_html_e("Theme", "socialv"); ?></h6>
                    <div class="row row-cols-2 mb-4">
                        <div data-setting="attribute" class="text-center">
                            <input type="radio" value="ltr" class="btn-check" name="theme_scheme_direction" data-prop="dir" id="theme-scheme-direction-ltr" checked="">
                            <label class="btn-box d-block p-0" for="theme-scheme-direction-ltr">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/01.png'); ?>" alt="ltr" class="mode dark-img img-fluid" loading="lazy" width="200" height="200">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/01.png'); ?>" alt="ltr" class="mode light-img img-fluid" loading="lazy" width="200" height="200">
                            </label>
                            <span class=" mt-2"> <?php esc_html_e("LTR", "socialv"); ?> </span>
                        </div>
                        <div data-setting="attribute" class="text-center">
                            <input type="radio" value="rtl" class="btn-check" name="theme_scheme_direction" data-prop="dir" id="theme-scheme-direction-rtl">
                            <label class="btn-box d-block p-0" for="theme-scheme-direction-rtl">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/02.png'); ?>" alt="ltr" class="mode dark-img img-fluid" loading="lazy" width="200" height="200">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/02.png'); ?>" alt="ltr" class="mode light-img img-fluid" loading="lazy" width="200" height="200">
                            </label>
                            <span class=" mt-2"> <?php esc_html_e("RTL", "socialv"); ?> </span>
                        </div>
                    </div>
                </div>
                <hr class="hr-horizontal">
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mt-4 mb-3"><?php esc_html_e("Color Customizer", "socialv"); ?></h6>
                        <div class="d-flex align-items-center">
                            <a href="#custom-color" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="custom-color"><?php esc_html_e("Custom", "socialv"); ?></a>
                            <div data-setting="radio" class="ms-2">
                                <input type="radio" value="theme-color-default" class="btn-check" name="theme_color" id="theme-color-default" data-colors='{"primary": "#2f65b9"}'>
                                <label class="bg-transparent border-0" for="theme-color-default" title="Reset Color">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.4799 12.2424C21.7557 12.2326 21.9886 12.4482 21.9852 12.7241C21.9595 14.8075 21.2975 16.8392 20.0799 18.5506C18.7652 20.3986 16.8748 21.7718 14.6964 22.4612C12.518 23.1505 10.1711 23.1183 8.01299 22.3694C5.85488 21.6205 4.00382 20.196 2.74167 18.3126C1.47952 16.4293 0.875433 14.1905 1.02139 11.937C1.16734 9.68346 2.05534 7.53876 3.55018 5.82945C5.04501 4.12014 7.06478 2.93987 9.30193 2.46835C11.5391 1.99683 13.8711 2.2599 15.9428 3.2175L16.7558 1.91838C16.9822 1.55679 17.5282 1.62643 17.6565 2.03324L18.8635 5.85986C18.945 6.11851 18.8055 6.39505 18.549 6.48314L14.6564 7.82007C14.2314 7.96603 13.8445 7.52091 14.0483 7.12042L14.6828 5.87345C13.1977 5.18699 11.526 4.9984 9.92231 5.33642C8.31859 5.67443 6.8707 6.52052 5.79911 7.74586C4.72753 8.97119 4.09095 10.5086 3.98633 12.1241C3.8817 13.7395 4.31474 15.3445 5.21953 16.6945C6.12431 18.0446 7.45126 19.0658 8.99832 19.6027C10.5454 20.1395 12.2278 20.1626 13.7894 19.6684C15.351 19.1743 16.7062 18.1899 17.6486 16.8652C18.4937 15.6773 18.9654 14.2742 19.0113 12.8307C19.0201 12.5545 19.2341 12.3223 19.5103 12.3125L21.4799 12.2424Z" fill="#31BAF1" />
                                        <path d="M20.0941 18.5594C21.3117 16.848 21.9736 14.8163 21.9993 12.7329C22.0027 12.4569 21.7699 12.2413 21.4941 12.2512L19.5244 12.3213C19.2482 12.3311 19.0342 12.5633 19.0254 12.8395C18.9796 14.283 18.5078 15.6861 17.6628 16.8739C16.7203 18.1986 15.3651 19.183 13.8035 19.6772C12.2419 20.1714 10.5595 20.1483 9.01246 19.6114C7.4654 19.0746 6.13845 18.0534 5.23367 16.7033C4.66562 15.8557 4.28352 14.9076 4.10367 13.9196C4.00935 18.0934 6.49194 21.37 10.008 22.6416C10.697 22.8908 11.4336 22.9852 12.1652 22.9465C13.075 22.8983 13.8508 22.742 14.7105 22.4699C16.8889 21.7805 18.7794 20.4073 20.0941 18.5594Z" fill="#0169CA" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="custom-color">
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label class="" for="custom-primary-color"><?php esc_html_e("Primary", "socialv"); ?></label>
                            <input class="" name="theme_color" data-extra="primary" type="color" id="custom-primary-color" value="#2f65b9" data-setting="color">
                        </div>
                    </div>
                    <div class="row row-cols-5 mb-4">
                        <div class="col" data-setting="radio">
                            <input type="radio" value="theme-color-blue" class="btn-check" name="theme_color" id="theme-color-1" data-colors='{"primary": "#074f3c"}'>
                            <label class="btn-box d-block bg-transparent" for="theme-color-1" title="Theme-1">
                                <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
                                    <circle cx="12" cy="12" r="10" fill="#074f3c" />
                                    <path d="M2,12 a1,1 1 1,0 20,0" fill="#074f3c" />
                                </svg>
                            </label>
                        </div>
                        <div class="col" data-setting="radio">
                            <input type="radio" value="theme-color-gray" class="btn-check" name="theme_color" id="theme-color-2" data-colors='{"primary": "#303779"}'>
                            <label class="btn-box d-block bg-transparent" for="theme-color-2" title="Theme-2">
                                <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
                                    <circle cx="12" cy="12" r="10" fill="#303779" />
                                    <path d="M2,12 a1,1 1 1,0 20,0" fill="#303779" />
                                </svg>
                            </label>
                        </div>
                        <div class="col" data-setting="radio">
                            <input type="radio" value="theme-color-red" class="btn-check" name="theme_color" id="theme-color-3" data-colors='{"primary": "#05bbc9"}'>
                            <label class="btn-box d-block bg-transparent" for="theme-color-3" title="Theme-3">
                                <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
                                    <circle cx="12" cy="12" r="10" fill="#05bbc9" />
                                    <path d="M2,12 a1,1 1 1,0 20,0" fill="#05bbc9" />
                                </svg>
                            </label>
                        </div>
                        <div class="col" data-setting="radio">
                            <input type="radio" value="theme-color-yellow" class="btn-check" name="theme_color" id="theme-color-4" data-colors='{"primary": "#ea4c89"}'>
                            <label class="btn-box d-block bg-transparent" for="theme-color-4" title="Theme-4">
                                <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
                                    <circle cx="12" cy="12" r="10" fill="#ea4c89" />
                                    <path d="M2,12 a1,1 1 1,0 20,0" fill="#ea4c89" />
                                </svg>
                            </label>
                        </div>
                        <div class="col" data-setting="radio">
                            <input type="radio" value="theme-color-pink" class="btn-check" name="theme_color" id="theme-color-5" data-colors='{"primary": "#4fb5ff"}'>
                            <label class="btn-box d-block bg-transparent" for="theme-color-5" title="Theme-5">
                                <svg class="customizer-btn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26">
                                    <circle cx="12" cy="12" r="10" fill="#4fb5ff" />
                                    <path d="M2,12 a1,1 1 1,0 20,0" fill="#4fb5ff" />
                                </svg>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Color customizer end here -->
                <hr class="hr-horizontal">
                <!-- Menu color start here -->
                <div>
                    <h6 class="mt-4 mb-3"><?php esc_html_e("Sidebar Color", "socialv"); ?></h6>
                    <div class="row row-cols-2 mb-4">
                        <div data-setting="radio" class="col mb-3">
                            <input type="radio" value="sidebar-white" class="btn-check" name="sidebar_color" id="sidebar-white" checked>
                            <label class="btn-box d-flex align-items-center justify-content-center bg-transparent" for="sidebar-white" title="Sidebar White">
                                <i class="text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-18" width="18" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="12" r="8" fill="currentColor" stroke="black" stroke-width="3"></circle>
                                    </svg>
                                </i>
                                <span class="ms-2 "><?php esc_html_e("Default", "socialv"); ?></span>
                            </label>
                        </div>
                        <div data-setting="radio" class="col mb-3">
                            <input type="radio" value="sidebar-dark" class="btn-check" name="sidebar_color" id="sidebar-dark">
                            <label class="btn-box d-flex align-items-center justify-content-center bg-transparent" for="sidebar-dark" title="Sidebar Dark">
                                <i class="text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-18" width="18" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                    </svg>
                                </i>
                                <span class="ms-2 "><?php esc_html_e("Dark", "socialv"); ?></span>
                            </label>
                        </div>
                        <div data-setting="radio" class="col">
                            <input type="radio" value="sidebar-color" class="btn-check" name="sidebar_color" id="sidebar-color">
                            <label class="btn-box d-flex align-items-center justify-content-center bg-transparent" for="sidebar-color" title="Sidebar Colored">
                                <i class="text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-18" width="18" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                    </svg>
                                </i>
                                <span class="ms-2 "><?php esc_html_e("Color", "socialv"); ?></span>
                            </label>
                        </div>
                        <div data-setting="radio" class="col">
                            <input type="radio" value="sidebar-transparent" class="btn-check" name="sidebar_color" id="sidebar-transparent">
                            <label class="btn-box d-flex align-items-center justify-content-center bg-transparent" for="sidebar-transparent" title="Sidebar Transparent">
                                <i class="text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-18" width="18" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="12" r="8" fill="#F5F6FA" stroke="black" stroke-width="3"></circle>
                                    </svg>
                                </i>
                                <span class="ms-2"><?php esc_html_e("Transparent", "socialv"); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Menu color end here -->
                <hr class="hr-horizontal">
                <!-- Menu Style start here -->
                <div>
                    <h6 class="mt-4 mb-3"><?php esc_html_e("Menu Style", "socialv"); ?></h6>
                    <div class="row row-cols-3 mb-4">
                        <div data-setting="checkbox" class="col text-center">
                            <input type="checkbox" value="sidebar-mini" class="btn-check" name="sidebar_type" id="sidebar-mini">
                            <label class="btn-box p-0 d-block overflow-hidden" for="sidebar-mini">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/03.png'); ?>" alt="<?php esc_attr_e('mini', 'socialv'); ?>" class="mode dark-img img-fluid" width="200" height="200" loading="lazy">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/03.png'); ?>" alt="<?php esc_attr_e('mini', 'socialv'); ?>" class="mode light-img img-fluid" width="200" height="200" loading="lazy">
                            </label>
                            <span class="mt-2"><?php esc_html_e("Mini", "socialv"); ?></span>
                        </div>
                        <div data-setting="checkbox" class="col text-center">
                            <input type="checkbox" value="sidebar-hover" 
                            data-extra="{target: '.sidebar', ClassListAdd: 'sidebar-mini'}" 
                            class="btn-check" name="sidebar_type" id="sidebar-hover">
                            <label class="btn-box p-0 d-block overflow-hidden" for="sidebar-hover">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/04.png'); ?>" alt="<?php esc_attr_e('hover', 'socialv'); ?>" class="mode dark-img img-fluid" width="200" height="200" loading="lazy">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/04.png'); ?>" alt="<?php esc_attr_e('hover', 'socialv'); ?>" class="mode light-img img-fluid" width="200" height="200" loading="lazy">
                            </label>
                            <span class="mt-2"><?php esc_html_e("Hover", "socialv"); ?></span>
                        </div>
                        <div data-setting="checkbox" class="col text-center">
                            <input type="checkbox" value="sidebar-boxed" class="btn-check" name="sidebar_type" id="sidebar-boxed">
                            <label class="btn-box p-0 d-block overflow-hidden" for="sidebar-boxed">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/05.png'); ?>" alt="<?php esc_attr_e('boxed', 'socialv'); ?>" class="mode dark-img img-fluid" width="200" height="200" loading="lazy">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/05.png'); ?>" alt="<?php esc_attr_e('boxed', 'socialv'); ?>" class="mode light-img img-fluid" width="200" height="200" loading="lazy">
                            </label>
                            <span class="mt-2"><?php esc_html_e("Boxed", "socialv"); ?></span>
                        </div>
                    </div>
                </div>
                <!-- Menu Style end here -->
                <hr class="hr-horizontal">
                <!-- Active Menu Style start here -->
                <div>
                    <h6 class="mt-4 mb-3"><?php esc_html_e("Active Menu Style", "socialv"); ?></h6>
                    <div class="row row-cols-3 mb-4">
                        <div data-setting="radio" class="text-center col mb-3">
                            <input type="radio" value="navs-rounded-all" class="btn-check" name="sidebar_menu_style" id="navs-rounded-all">
                            <label class="btn-box p-0 d-block overflow-hidden" for="navs-rounded-all">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/07.png'); ?>" alt="<?php esc_attr_e('hover', 'socialv'); ?>" class="mode dark-img img-fluid" width="200" height="200" loading="lazy">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/07.png'); ?>" alt="<?php esc_attr_e('hover', 'socialv'); ?>" class="mode light-img img-fluid" width="200" height="200" loading="lazy">
                            </label>
                            <span class="mt-2"><?php esc_html_e("Rounded All", "socialv"); ?></span>
                        </div>
                        <div data-setting="radio" class="text-center col mb-3">
                            <input type="radio" value="navs-rounded" class="btn-check" name="sidebar_menu_style" id="navs-rounded">
                            <label class="btn-box p-0 d-block overflow-hidden" for="navs-rounded">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/06.png'); ?>" alt="<?php esc_attr_e('mini', 'socialv'); ?>" class="mode dark-img img-fluid" width="200" height="200" loading="lazy">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/06.png'); ?>" alt="<?php esc_attr_e('mini', 'socialv'); ?>" class="mode light-img img-fluid" width="200" height="200" loading="lazy">
                            </label>
                            <span class="mt-2"><?php esc_html_e("Rounded One Side", "socialv"); ?></span>
                        </div>
                        <div data-setting="radio" class="text-center col">
                            <input type="radio" value="navs-pill-all" class="btn-check" name="sidebar_menu_style" id="navs-pill-all">
                            <label class="btn-box p-0 d-block overflow-hidden" for="navs-pill-all">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/08.png'); ?>" alt="<?php esc_attr_e('boxed', 'socialv'); ?>" class="mode dark-img img-fluid" width="200" height="200" loading="lazy">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/08.png'); ?>" alt="<?php esc_attr_e('boxed', 'socialv'); ?>" class="mode light-img img-fluid" width="200" height="200" loading="lazy">
                            </label>
                            <span class="mt-2"><?php esc_html_e("Pill All", "socialv"); ?></span>
                        </div>
                        <div data-setting="radio" class="text-center col mb-3">
                            <input type="radio" value="navs-pill" class="btn-check" name="sidebar_menu_style" id="navs-pill">
                            <label class="btn-box p-0 d-block overflow-hidden" for="navs-pill">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/09.png'); ?>" alt="<?php esc_attr_e('boxed', 'socialv'); ?>" class="mode dark-img img-fluid" width="200" height="200" loading="lazy">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/09.png'); ?>" alt="<?php esc_attr_e('boxed', 'socialv'); ?>" class="mode light-img img-fluid" width="200" height="200" loading="lazy">
                            </label>
                            <span class="mt-2"><?php esc_html_e("Pill One Side", "socialv"); ?></span>
                        </div>
                        <div data-setting="radio" class="text-center col">
                            <input type="radio" value="left-bordered" class="btn-check" name="sidebar_menu_style" id="left-bordered" checked>
                            <label class="btn-box p-0 d-block overflow-hidden" for="left-bordered">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/14.png'); ?>" alt="<?php esc_attr_e('boxed', 'socialv'); ?>" class="mode dark-img img-fluid" width="200" height="200" loading="lazy">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/14.png'); ?>" alt="<?php esc_attr_e('boxed', 'socialv'); ?>" class="mode light-img img-fluid" width="200" height="200" loading="lazy">
                            </label>
                            <span class="mt-2"><?php esc_html_e("Left Bordered", "socialv"); ?></span>
                        </div>
                    </div>
                </div>
                <!-- Active Menu Style end here -->
                <hr class="hr-horizontal">
                <!-- Navbar style start here -->
                <div>
                    <h6 class="mt-4 mb-3"><?php esc_html_e("Navbar Style", "socialv"); ?></h6>
                    <div class="row row-cols-3 mb-4">
                        <div data-setting="radio" class="text-center col">
                            <input type="radio" value="header-default" class="btn-check" name="header_navbar" id="header-default" checked>
                            <label class="btn-box p-0 d-block overflow-hidden" for="header-default">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/01.png'); ?>" alt="<?php esc_attr_e('default', 'socialv'); ?>" class="mode dark-img img-fluid" width="200" height="200" loading="lazy">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/01.png'); ?>" alt="<?php esc_attr_e('default', 'socialv'); ?>" class="mode light-img img-fluid" width="200" height="200" loading="lazy">
                            </label>
                            <span class="mt-2"><?php esc_html_e("Default", "socialv"); ?></span>
                        </div>
                        <div data-setting="radio" class="text-center col">
                            <input type="radio" value="header-glass" class="btn-check" name="header_navbar" id="header-glass">
                            <label class="btn-box p-0 d-block overflow-hidden" for="header-glass">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/10.png'); ?>" alt="<?php esc_attr_e('hover', 'socialv'); ?>" class="mode dark-img img-fluid" width="200" height="200" loading="lazy">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/10.png'); ?>" alt="<?php esc_attr_e('hover', 'socialv'); ?>" class="mode light-img img-fluid" width="200" height="200" loading="lazy">
                            </label>
                            <span class="mt-2"><?php esc_html_e("Glass", "socialv"); ?></span>
                        </div>
                        <div data-setting="radio" class="text-center col">
                            <input type="radio" value="header-transparent" class="btn-check" name="header_navbar" id="header-transparent">
                            <label class="btn-box p-0 d-block overflow-hidden" for="header-transparent">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/dark/12.png'); ?>" alt="<?php esc_attr_e('boxed', 'socialv'); ?>" class="mode dark-img img-fluid" width="200" height="200" loading="lazy">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/redux/layout/light/12.png'); ?>" alt="<?php esc_attr_e('boxed', 'socialv'); ?>" class="mode light-img img-fluid" width="200" height="200" loading="lazy">
                            </label>
                            <span class="mt-2"><?php esc_html_e("Transparent", "socialv"); ?></span>
                        </div>
                    </div>
                </div>
                <!-- Navbar style end here -->
            </div>
        </div>
    </div>
</div>