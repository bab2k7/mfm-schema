<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function outputSchema() {
    if(get_option('org-enabled')){
        ?>
        <div id="schema-data-organisation" style="display: none !important;">
            <div itemscope itemtype="http://schema.org/Organization">
                <span itemprop="brand"><?php echo get_option('org-brand'); ?></span>
                <span itemprop="url"><?php echo get_option('org-website_url'); ?></span>
                <span itemprop="logo"><?php echo get_option('org-logo_url'); ?></span>
                <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                    <span itemprop="streetAddress"><?php echo get_option('org-street'); ?></span>
                    <span itemprop="addressLocality"><?php echo get_option('org-town'); ?></span>
                    <span itemprop="addressRegion"><?php echo get_option('org-county'); ?></span>
                    <span itemprop="postalCode"><?php echo get_option('org-postcode'); ?></span>
                    <span itemprop="addressCountry"><?php echo get_option('org-country'); ?></span>
                </div>
                <div itemprop="contactPoint" itemscope itemtype="http://schema.org/ContactPoint">
                    <span itemprop="contactType">Customer Services</span>
                    <span itemprop="email"><?php echo get_option('org-email'); ?></span>
                    <span itemprop="telephone"><?php echo get_option('org-telephone'); ?></span>
                    <span itemprop="faxNumber"><?php echo get_option('org-fax'); ?></span>
                </div>
            </div>
        </div>
        <?php if(get_option('place-enabled')){ ?>
        <div id="schema-data-place" style="display: none !important;">
            <div itemscope itemtype="http://schema.org/Place">
                <span itemprop="photo"><?php echo get_option('place-photo'); ?></span>
                <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
                    <span itemprop="latitude"><?php echo get_option('place-latitude'); ?></span>
                    <span itemprop="longitude"><?php echo get_option('place-longitude'); ?></span>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if(get_option('local-enabled')){ ?>
        <div id="schema-data-localbusiness" style="display: none !important;">
            <div itemscope itemtype="http://schema.org/LocalBusiness">
                <time itemprop="openingHours" datetime="Mo <?php echo get_option('local-times-mon'); ?>" />
                <time itemprop="openingHours" datetime="Tu <?php echo get_option('local-times-tue'); ?>" />
                <time itemprop="openingHours" datetime="We <?php echo get_option('local-times-wed'); ?>" />
                <time itemprop="openingHours" datetime="Th <?php echo get_option('local-times-thu'); ?>" />
                <time itemprop="openingHours" datetime="Fr <?php echo get_option('local-times-fri'); ?>" />
                <time itemprop="openingHours" datetime="Sa <?php echo get_option('local-times-sat'); ?>" />
                <time itemprop="openingHours" datetime="Su <?php echo get_option('local-times-sun'); ?>" />
            </div>
        </div>
        <?php } ?>
        <?php
    }
	if(get_option('article-enabled')){        
          outputArticleSchema(); 
    }
          
        
}

function outputArticleSchema() {
    global $post;
    $outputArtSchema = false;
    $selectedCats = get_option('art-cats');
    $selectedArray = explode(',', $selectedCats);
    if($post->post_type == 'post'){
        if(!is_archive()){
           $categories = wp_get_post_categories($post->ID);
            foreach($categories as $cat_id){
                if(in_array($cat_id, $selectedArray)){
                    $outputArtSchema = true;
                }
            }
            if($outputArtSchema){
                ?>
                <div itemscope itemtype="http://schema.org/NewsArticle" style="display:none;">
                    <meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="https://google.com/article"/>
                    <div itemprop="headline"><?php the_title($post->ID); ?></div>
                    <div itemprop="author" itemscope itemtype="https://schema.org/Person">
                        By <span itemprop="name"><?php the_author($post->ID); ?></span>
                    </div>
                    <span itemprop="description"><?php the_excerpt($post->ID); ?></span>
                    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                        <?php if (the_post_thumbnail_url($post->ID, 'thumbnail' )){?>
						<img src="<?php the_post_thumbnail_url($post->ID, 'thumbnail' ); ?>"/>						
						<meta itemprop="url" content="<?php the_post_thumbnail_url($post->ID, 'thumbnail' ); ?>">
                        <meta itemprop="width" content="150">
                        <meta itemprop="height" content="150">	
						<?php }else{ ?>	
						<img src="<?php echo get_option('org-logo_url'); ?>"/>						
						<meta itemprop="url" content="<?php echo get_option('org-logo_url'); ?>">
                        <meta itemprop="width" content="150">
                        <meta itemprop="height" content="150">
						<?php } ?>
                    </div>
                    <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                            <img src="<?php echo get_option('org-logo_url'); ?>"/>
                            <meta itemprop="url" content="<?php echo get_option('org-logo_url'); ?>">
                            <meta itemprop="width" content="300">
                            <meta itemprop="height" content="200">
                        </div>
                        <meta itemprop="name" content="<?php echo get_option('org-brand'); ?>">
                    </div>
                    <meta itemprop="datePublished" content="<?php the_time( 'c', $post->ID ); ?>"/>
                    <meta itemprop="dateModified" content="<?php the_modified_time( 'c', $post->ID ); ?>"/>
                </div>


                <!-- Hentry Post Output -->
                
                <script>
                    {
                    "items": [
                      {
                        "type": [
                          "h-entry"
                        ],
                        "properties": {
                          "name": [
                            "<?php the_title($post->ID); ?>"
                          ],
                          "author": [
                            {
                              "value": "<?php the_author($post->ID); ?>",
                              "type": [
                                "h-card"
                              ]
                            }
                          ],
                          "published": [
                            "<?php the_time( 'c', $post->ID ); ?>"
                          ],
                          "summary": [
                            "<?php the_excerpt($post->ID); ?>"
                          ],
                          "content": [
                            {
                              "value": "<?php the_excerpt($post->ID); ?>",
                              "html": "<?php the_excerpt($post->ID); ?>"
                            }
                          ]
                        }
                      }
                    ]
                  }
                </script>
                
                <?php
            }
        }
        else{
            ?>
                <!-- Hentry Archive Output -->
            <?php
        }
    }
    
    
}