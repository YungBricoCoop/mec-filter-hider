# M.E.C Filter Hider
This WP Plugin is made to hide some filters from the M.E.C Admin page. 

# Installation 
1. Download the zip file from the **Release page** : 
https://github.com/YungBricoCoop/mec-filter-hider/releases/tag/v1.0
2. Upload it to WordPress
3. Activate the plugin

# Settings
By default, the plugin displays all the filters.  </br>
If you want to hide only certain filters, just separate them with a **comma**.    </br>

In the **Container** and **Elements** inputs you can enter a JS Path request, here is the format you need to use : </br>

For **id** use **#** (ex : #name_filter)  </br>
For **class** use **.** (ex : .name_filter)    </br>
For **custom attribut** use **attribut=value** (ex : data-filter=filter_name)  </br>
**Complex** JS Path can also be used  </br>

## Container

The container is where the elements you want to hide are situated.   </br>
Its purpose is only to avoid hiding elements on the page other than in itself.

## Elements

You can indicate multiple elements just by spliting them with commas.