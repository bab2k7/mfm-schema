<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function outputSchema() {
    if(get_option('org-enabled')){
        ?>
        <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "Organization",
                "url": "<?php echo get_option('org-website_url'); ?>",
                "logo": "<?php echo get_option('org-logo_url'); ?>",
                "email": "mailto:<?php echo get_option('org-email'); ?>",
                "address": {
                                "@type": "PostalAddress",
                                "addressLocality": "<?php echo get_option('org-town'); ?>",
                                "addressRegion": "<?php echo get_option('org-county'); ?>",
                                "addressCountry":"<?php echo get_option('org-country'); ?>",
                                "postalCode": "<?php echo get_option('org-postcode'); ?>",
                                "streetAddress": "<?php echo get_option('org-street'); ?>"
                },
                "brand": "<?php echo get_option('org-brand'); ?>",
                "telephone": "<?php echo get_option('org-telephone'); ?>",
                "faxNumber": "<?php echo get_option('org-fax'); ?>"
            }
        </script>

        <?php if(get_option('place-enabled')){ ?>
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Place",            
            "geo": {
                            "@type": "GeoCoordinates",
                            "latitude": "<?php echo get_option('place-latitude'); ?>",
                            "longitude": "<?php echo get_option('place-longitude'); ?>"
            },
            "photo": "<?php echo get_option('place-photo'); ?>"
        }
        </script>
        <?php } ?>
        <?php if(get_option('local-enabled')){ ?>
        <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "LocalBusiness",
                
                "openingHoursSpecification": [
                    {
                      "@type": "OpeningHoursSpecification",
                      "closes":  "<?php echo get_option('local-close-times-sun'); ?>",
                      "dayOfWeek": "http://schema.org/Sunday",
                      "opens":  "<?php echo get_option('local-open-times-sun'); ?>"
                    },
                    {
                      "@type": "OpeningHoursSpecification",
                      "closes": "<?php echo get_option('local-close-times-sat'); ?>" ,
                      "dayOfWeek": "http://schema.org/Saturday",
                      "opens": "<?php echo get_option('local-open-times-sat'); ?>"
                    },
                    {
                      "@type": "OpeningHoursSpecification",
                      "closes":  "<?php echo get_option('local-close-times-thu'); ?>",
                      "dayOfWeek": "http://schema.org/Thursday",
                      "opens": "<?php echo get_option('local-open-times-thu'); ?>"
                    },
                    {
                      "@type": "OpeningHoursSpecification",
                      "closes": "<?php echo get_option('local-close-times-tue'); ?>",
                      "dayOfWeek": "http://schema.org/Tuesday",
                      "opens": "<?php echo get_option('local-open-times-tue'); ?>"
                    },
                    {
                      "@type": "OpeningHoursSpecification",
                      "closes": "<?php echo get_option('local-close-times-fri'); ?>",
                      "dayOfWeek":  "http://schema.org/Friday",
                      "opens": "<?php echo get_option('local-open-times-fri'); ?>"
                    },
                    {
                      "@type": "OpeningHoursSpecification",
                      "closes": "<?php echo get_option('local-close-times-mon'); ?>",
                      "dayOfWeek": "http://schema.org/Monday",
                      "opens": "<?php echo get_option('local-open-times-mon'); ?>"
                    },
                    {
                      "@type": "OpeningHoursSpecification",
                      "closes": "<?php echo get_option('local-close-times-wed'); ?>",
                      "dayOfWeek":  "http://schema.org/Wednesday",
                      "opens": "<?php echo get_option('local-open-times-wed'); ?>"
                    }
                ]
            }
        </script>
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
                <script type="application/ld+json">
                {
                  "@context": "http://schema.org",
                  "@type": "NewsArticle",
                  "mainEntityOfPage":{
                    "@type":"WebPage"
                  },
                  "headline": "<?php the_title($post->ID); ?>",
                  "image": {
                    "@type": "ImageObject",
                    "url": "<?php the_post_thumbnail_url($post->ID, 'thumbnail' ); ?>",
                    "height": "150",
                    "width": "150"
                  },
                  "datePublished": "<?php the_time( 'c', $post->ID ); ?>",
                  "dateModified": "<?php the_modified_time( 'c', $post->ID ); ?>",
                  "author": {
                    "@type": "Person",
                    "name": "<?php the_author($post->ID); ?>"
                  },
                   "publisher": {
                    "@type": "Organization",
                    "name": "<?php echo get_option('org-brand'); ?>",
                    "logo": {
                      "@type": "ImageObject",
                      "url": "<?php echo get_option('org-logo_url'); ?>",
                      "width": "200",
                      "height": "200"
                    }
                  },
                  "description": "<?php echo wp_strip_all_tags(get_the_excerpt($post->ID)); ?>"
                }
                </script>


                <!-- Hentry Post Output -->
                
                <script type="application/ld+json">
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
            
        }
    }
    
    
}