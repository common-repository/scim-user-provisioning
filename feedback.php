<?php

function msup_scim_display_scim_feedback_form() {
    if ( 'plugins.php' != basename( $_SERVER['PHP_SELF'] ) ) {
        return;
    }

    wp_enqueue_style( 'wp-pointer' );
    wp_enqueue_script( 'wp-pointer' );
    wp_enqueue_script( 'utils' );
    wp_enqueue_style( 'msup_scim_admin_plugins_page_style', plugins_url( '/includes/css/style_settings.css', __FILE__ ) );

    ?>

    </head>
    <body>
    <div id="msup_feedback_modal" class="msup_modal" style="width:90%; margin-left:12%; margin-top:5%; text-align:center; margin-left; display:none;">

        <div class="msup_modal-content" style="width:50%;">
            <h3 style="margin: 2%; text-align:center;"><b>Your feedback</b><span class="msup_close" style="cursor: pointer;">&times;</span>
            </h3>
            <hr style="width:75%;">
            
            <form name="msup_feedback" method="post" action="" id="msup_feedback">
                <?php wp_nonce_field("msup_feedback");?>
                <input type="hidden" name="option" value="msup_feedback"/>
                <div>
                    <p style="margin:2%">
                    <h4 style="margin: 2%; text-align:center;">Please help us to improve our plugin by giving your opinion.<br></h4>
                    
                    <div id="msup_smi_rate" style="text-align:center">
                    <input type="radio" name="rate" id="msup_angry" value="1"/>
                        <label for="msup_angry"><img class="sm" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/angry.png'; ?>" />
                        </label>
                        
                    <input type="radio" name="rate" id="msup_sad" value="2"/>
                        <label for="msup_sad"><img class="sm" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/sad.png'; ?>" />
                        </label>
                    
                    
                    <input type="radio" name="rate" id="msup_normal" value="3"/>
                        <label for="msup_normal"><img class="sm" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/normal.png'; ?>" />
                        </label>
                        
                    <input type="radio" name="rate" id="msup_smile" value="4"/>
                        <label for="msup_smile">
                        <img class="sm" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/smile.png'; ?>" />
                        </label>
                        
                    <input type="radio" name="rate" id="msup_happy" value="5" checked/>
                        <label for="msup_happy"><img class="sm" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/happy.png'; ?>" />
                        </label>
                        
                    <div id="msup_outer" style="visibility:visible"><span id="msup_result">Thank you for appreciating our work</span></div>
                    </div><br>
                    <hr style="width:75%;">
                    <?php 
                        if(empty($email)){
                            $user = wp_get_current_user();
                            $email = $user->user_email;
                        }
                        ?>
                    <div style="text-align:center;">
                        
                        <div style="display:inline-block; width:60%;">
                        <input type="email" id="msup_query_mail" name="msup_query_mail" style="text-align:center; border:0px solid black; border-style:solid; background:#f0f3f7; width:20vw;border-radius: 6px;"
                              placeholder="your email address" required value="<?php echo $email; ?>" readonly="readonly"/>
                        
                        <input type="radio" name="msup_edit" id="msup_edit" onclick="msup_editName()" value=""/>
                        <label for="msup_edit"><img class="editable" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/61456.png'; ?>" />
                        </label>
                        
                        </div>
                        <br><br>
                        <textarea id="msup_query_feedback" name="msup_query_feedback" rows="4" style="width: 60%"
                              placeholder="Tell us what happened!"></textarea>
                        <br><br>
                          <input type="checkbox" name="msup_get_reply" value="reply" checked>miniOrange representative will reach out to you at the email-address entered above.</input>
                    </div>
                    <br>
                   
                    <div class="mo-modal-footer" style="text-align: center;margin-bottom: 2%">
                        <input type="submit" name="msup_feedback_submit"
                               class="button button-primary button-large" value="Send"/>
                        <span width="30%">&nbsp;&nbsp;</span>
                        <input type="button" name="msup_skip_feedback"
                               class="button button-primary button-large" value="Skip" onclick="document.getElementById('msup_feedback_form_close').submit();"/>
                    </div>
                </div>
                

            </form>
            <form name="f" method="post" action="" id="msup_feedback_form_close">
                <?php wp_nonce_field("msup_skip_feedback");?>
                <input type="hidden" name="option" value="msup_skip_feedback"/>
            </form>

        </div>

    </div>

    <script>
        jQuery('a[aria-label="Deactivate SCIM user provisioning"]').click(function () {
            var msup_modal = document.getElementById('msup_feedback_modal');

            var msup_span = document.getElementsByClassName("msup_close")[0];

            msup_modal.style.display = "block";
            document.querySelector("#msup_query_feedback").focus();
            msup_span.onclick = function () {
                msup_modal.style.display = "none";
                jQuery('#msup_feedback_form_close').submit();
            };

            window.onclick = function (event) {
                if (event.target === msup_modal) {
                    msup_modal.style.display = "none";
                }
            };
            return false;

        });

        let msup_INPUTS = document.querySelectorAll('#msup_smi_rate input');
        msup_INPUTS.forEach(el => el.addEventListener('click', (e) => msup_updateValue(e)));


        function msup_editName(){

            document.querySelector('#msup_query_mail').removeAttribute('readonly');
            document.querySelector('#msup_query_mail').focus();
            return false;

        }
        function msup_updateValue(e) {
            document.querySelector('#msup_outer').style.visibility="visible";
            var msup_result = 'Thank you for appreciating our work';
            switch(e.target.value){
                case '1':   msup_result = 'Not happy with our plugin ? Let us know what went wrong';
                    break;
                case '2':   msup_result = 'Found any issues? Let us know and we\'ll fix it ASAP';
                    break;
                case '3':   msup_result = 'Let us know if you need any help';
                    break;
                case '4':   msup_result = 'We\'re glad that you are happy with our plugin';
                    break;
                case '5':   msup_result = 'Thank you for appreciating our work';
                    break;
            }
            document.querySelector('#msup_result').innerHTML = msup_result;

        }
    </script><?php
}

?>