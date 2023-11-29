/* Open Graph protocol */

/*
meta[property="og:title]|content = $title

meta[property="og:locale"]|content = $this->seo['locale']
meta[property="og:type"]|content = $this->seo['type']
meta[property="og:title"]|content = $this->seo['title']
meta[property="og:description"]|content = $this->seo['description']
meta[property="og:url"]|content = $this->seo['url']
meta[property="og:site_name"]|content = $this->seo['site_name']

meta[property="article:author"]|content = $this->seo['author']
meta[property="article:published_time"]|content = $this->seo['published_time']
meta[property="article:modified_time"]|content = $this->seo['modified_time']


meta[property="og:image"]|content = $this->seo['image']
meta[property="og:image:width"]|content = $this->seo['image:width']
meta[property="og:image:height"]|content = $this->seo['image:height']
meta[property="og:image:type"]|content = $this->seo['image:type']


meta[name="twitter:card"]|content = $this->seo['twitter']['card']
meta[name="twitter:creator"]|content = $this->seo['twitter']['creator']
meta[name="twitter:site"]|content = $this->seo['twitter']['site']
meta[name="twitter:label1"]|content = $this->seo['twitter']['label1']
meta[name="twitter:data1"]|content = $this->seo['twitter']['data1']
meta[name="twitter:label2"]|content = $this->seo['twitter']['label2']
meta[name="twitter:data2"]|content = $this->seo['twitter']['data2']

*/


meta[name="author"]|content = $this->seo['author']

import(/plugins/seo/app/template/meta.tpl, {"attribute":"property","meta":"og"})
import(/plugins/seo/app/template/meta.tpl, {"attribute":"property","meta":"article"})
import(/plugins/seo/app/template/meta.tpl, {"attribute":"name","meta":"twitter"})

script[type="application/ld+json"] = $this->seo['json-schema-graph']
