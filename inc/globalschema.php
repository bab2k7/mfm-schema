<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function mfmSchema() {  
    global $wpdb;
    $sql = 'SELECT * FROM '.$wpdb->prefix.'mfm_schema_plugins';
    $modules = $wpdb->get_results($sql);
 
    ?>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<div class="mfm-schema-settings">
    <div class="page-container">
        <h1>MonkeyFish Schema.org Markup Settings</h1>
        <div class="settings-tabs">
            <div class="tab-headers">
                <div class="tab-header active" id="tab-general">
                    General
                </div>
                <div class="tab-header" id="tab-organisation">
                    Organisation
                </div>
                <div class="tab-header" id="tab-place">
                    Place/Location
                </div>
                <div class="tab-header" id="tab-local">
                    Local
                </div>
                <div class="tab-header" id="tab-article">
                    Article
                </div>
                <?php
                foreach($modules as $module){
                    
                    if(is_plugin_active($module->plugin_name.'/'.$module->plugin_name.'.php')){
                    ?>
                    <div class="tab-header" id="tab-<?php echo $module->plugin_name; ?>">
                        <?php echo $module->plugin_tidy_name; ?>
                    </div>
                    <?php
                    }
                }
                ?>
            </div>
            <div class="tab-datas">
                <form id="settings-form" method="post" action="options.php">
                    <?php 
                    settings_fields( 'mfm-schema-global' );
                    do_settings_sections( 'mfm-schema-global' );
                    ?>
                    <div class="tab-data tab-general active">
                        <h2>General</h2>
                        <div class="input-wrapper">
                            <label for="enable-menu">Enable Organisation Schema: </label>
                            <input type="checkbox" name="org-enabled" id="enable-menu" <?php if(get_option('org-enabled')){echo "checked";} ?>>
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Enable Place/Location Schema: </label>
                            <input type="checkbox" name="place-enabled" id="enable-menu" <?php if(get_option('place-enabled')){echo "checked";} ?>>
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Enable Local Schema: </label>
                            <input type="checkbox" name="local-enabled" id="enable-menu" <?php if(get_option('local-enabled')){echo "checked";} ?>>
                        </div>
                        <!-- <div class="input-wrapper">
                            <label for="enable-menu">Enable Breadcrumbs Schema: </label>
                            <input type="checkbox" name="breadcrumbs-enabled" id="enable-menu" <?php if(get_option('breadcrumbs-enabled')){echo "checked";} ?>>
                        </div> -->
                        <div class="input-wrapper">
                            <label for="enable-menu">Enable Article Schema: </label>
                            <input type="checkbox" name="article-enabled" id="enable-menu" <?php if(get_option('article-enabled')){echo "checked";} ?>>
                        </div>
                    </div>
                    <div class="tab-data tab-organisation">
                        <h2>Organisation</h2>
                        <div class="input-wrapper">
                            <label for="enable-menu">Brand: </label>
                            <input type="text" name="org-brand" value="<?php echo get_option('org-brand'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Website URL: </label>
                            <input type="text" name="org-website_url" value="<?php echo get_option('org-website_url'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Logo URL: </label>
                            <input type="text" name="org-logo_url" value="<?php echo get_option('org-logo_url'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Telephone Number: </label>
                            <input type="text" name="org-telephone" value="<?php echo get_option('org-telephone'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Fax Number: </label>
                            <input type="text" name="org-fax" value="<?php echo get_option('org-fax'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Email Address: </label>
                            <input type="text" name="org-email" value="<?php echo get_option('org-email'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Street: </label>
                            <input type="text" name="org-street" value="<?php echo get_option('org-street'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Town: </label>
                            <input type="text" name="org-town" value="<?php echo get_option('org-town'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">County: </label>
                            <input type="text" name="org-county" value="<?php echo get_option('org-county'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Post Code: </label>
                            <input type="text" name="org-postcode" value="<?php echo get_option('org-postcode'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Country: </label>
                            <input type="text" name="org-country" value="<?php echo get_option('org-country'); ?>">
                        </div>
                    </div>
                    <div class="tab-data tab-place">
                        <h2>Place/Location</h2>
                        <div class="input-wrapper">
                            <label for="enable-menu">Location Photo: </label>
                            <input type="text" name="place-photo" value="<?php echo get_option('place-photo'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Location Latitude: </label>
                            <input type="text" name="place-latitude" value="<?php echo get_option('place-latitude'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Location Longitude: </label>
                            <input type="text" name="place-longitude" value="<?php echo get_option('place-longitude'); ?>">
                        </div>
                    </div>
                    <div class="tab-data tab-local">
                        <div class="headers">
                            <h2 class="">Local Business</h2>
                            <h4 class="col-head">&nbsp;</h4><h4 class="col-head">Open</h4><h4 class="col-head">Close</h4>
                        </div>
                        <div class="clearfix"></div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Opening Hours Monday: </label>
                            <input type="text" name="local-open-times-mon" value="<?php echo get_option('local-open-times-mon'); ?>">
                            <input type="text" name="local-close-times-mon" value="<?php echo get_option('local-close-times-mon'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Opening Hours Tuesday: </label>
                            <input type="text" name="local-open-times-tue" value="<?php echo get_option('local-open-times-tue'); ?>">
                            <input type="text" name="local-close-times-tue" value="<?php echo get_option('local-close-times-tue'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Opening Hours Wednesday: </label>
                            <input type="text" name="local-open-times-wed" value="<?php echo get_option('local-open-times-wed'); ?>">
                            <input type="text" name="local-close-times-wed" value="<?php echo get_option('local-close-times-wed'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Opening Hours Thursday: </label>
                            <input type="text" name="local-open-times-thu" value="<?php echo get_option('local-open-times-thu'); ?>">
                            <input type="text" name="local-close-times-thu" value="<?php echo get_option('local-close-times-thu'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Opening Hours Friday: </label>
                            <input type="text" name="local-open-times-fri" value="<?php echo get_option('local-open-times-fri'); ?>">
                            <input type="text" name="local-close-times-fri" value="<?php echo get_option('local-close-times-fri'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Opening Hours Saturday: </label>
                            <input type="text" name="local-open-times-sat" value="<?php echo get_option('local-open-times-sat'); ?>">
                            <input type="text" name="local-close-times-sat" value="<?php echo get_option('local-close-times-sat'); ?>">
                        </div>
                        <div class="input-wrapper">
                            <label for="enable-menu">Opening Hours Sunday: </label>
                            <input type="text" name="local-open-times-sun" value="<?php echo get_option('local-open-times-sun'); ?>">
                            <input type="text" name="local-close-times-sun" value="<?php echo get_option('local-close-times-sun'); ?>">
                        </div>
                    </div>
                    <div class="tab-data tab-article">
                        <h2>Article</h2>
                        <p>Please select the categories you would like the schema enabled for.</p>
                        <?php
                        $categories = get_categories();
                        /*echo "<pre>";
                        var_dump($categories);
                        echo "</pre>";*/
                        foreach($categories as $category){
                            ?>
                            <div class="input-wrapper">
                                <label for="enable-menu"><?php echo $category->name; ?>: </label>
                                <input type="checkbox" class="cat-check" id="cat-id-<?php echo $category->cat_ID; ?>">
                            </div>
                            
                            <?php
                            
                        }
                        ?>
                        
                        <input type="hidden" name="art-cats" id="selected-cats" value="<?php echo get_option('art-cats'); ?>">
                    </div>
                    <div class="tab-data tab-other">
                        <h2>Other</h2>
                    </div>
                    <?php
                    foreach($modules as $module){
                        $moduleFunc = str_replace('-','_',$module->plugin_name);
                        if(is_plugin_active($module->plugin_name.'/'.$module->plugin_name.'.php')){
                        ?>
                        <div class="tab-data tab-<?php echo $module->plugin_name; ?>">
                            <h2><?php echo $module->plugin_tidy_name; ?></h2>
                            <?php call_user_func($moduleFunc); ?>
                        </div>
                        
                        <?php
                        }
                    }
                    ?>
                    <?php submit_button(); ?>
                </form>
            </div>
        </div>
         
    </div>
</div>

<script>
    
    
    
    var $mfmschema = jQuery.noConflict();
    
    $mfmschema( document ).ready(function() {
        var catList = $mfmschema('#selected-cats').val();
        var catArray = catList.split(',');
        $mfmschema.each(catArray, function( index, value ) {
            $mfmschema('#cat-id-'+value).prop('checked', true);
        });
    });
    
    $mfmschema('.tab-header').click(function() {
        var tabId = $mfmschema(this).attr('id');
        $mfmschema('.tab-header').removeClass('active');
        $mfmschema('.tab-data').removeClass('active');
        $mfmschema(this).addClass('active');
        $mfmschema('.'+tabId).addClass('active');
    });
    
    $mfmschema('.cat-check').click(function() {
        
        var checkedIds = $mfmschema(".cat-check:checked").map(function() {
            var catId = this.id.replace('cat-id-', '');
            return catId;
        }).get();
        $mfmschema("#selected-cats").val(checkedIds);
        console.log(checkedIds);
    });
</script>
    <?php
    
}