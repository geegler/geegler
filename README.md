# geegler
Mini PHP Framework

Installation by composer
1. Create a composer.json file as shown below. TBS or tinyButStrong and Twig template engines are included.
   Geegler utilizes either TBS or TWIG template engine. Smarty template engine can also be used.



       {
              "minimum-stability": "dev",
		                    "require":{
	                                  "geegler/geegler": "dev-master",
	                                  "tinybutstrong/tinybutstrong": "dev-master",
	                                  "twig/twig": "*"
    			                        },
                       "repositories": [
                                         {
                                           "type": "vcs",
                                           "url": "https://github.com/geegler/geegler"
                                         }
                                       ]

       }
    
    
    
2. Make sure the directories are created as shown below. The vendor directory however will be created by the compser

        public_html
                 app/
                    config
                         xml
                    controllers
                    models
                    helpers
                 public/
                    html/
                       js
                       style
                       templates/
                               tbs
                               twig/
                                   cache/ 
        vendor
