<title>{{ $seo['title'] }}</title>
<meta name="description" content="{{ $seo['description'] }}"/>
@if($seo['keywords']!='')
<meta name="keywords" content="{{ $seo['keywords'] }}"/>
@endif
<meta property="og:title" content="{{ $seo['og_title'] }}"/>
<meta property="og:description" content="{{ $seo['og_description'] }}"/>
<meta property="og:url" content="{{ $seo['og_url'] }}"/>
<meta property="og:type" content="article"/>
<meta property="og:image" content="{{ $seo['og_img'] }}"/>
<meta property="fb:app_id" content="842214992892805"/>
<link rel="canonical" href="{{ $seo['current_url'] }}"/>
<?php 
$current_url_home_page = URL::current();
?>
<link href='//fonts.googleapis.com' rel='dns-prefetch'/>
<link href='//ajax.googleapis.com' rel='dns-prefetch'/>
<link href='//apis.google.com' rel='dns-prefetch'/>
<link href='//connect.facebook.net' rel='dns-prefetch'/>
<link href='//www.facebook.com' rel='dns-prefetch'/>
<link href='//twitter.com' rel='dns-prefetch'/>
<link href='//www.google-analytics.com' rel='dns-prefetch'/>
<link href='//www.googletagservices.com' rel='dns-prefetch'/>
<link href='//pagead2.googlesyndication.com' rel='dns-prefetch'/>
<link href='//googleads.g.doubleclick.net' rel='dns-prefetch'/>
<link href='//static.xx.fbcdn.net' rel='dns-prefetch'/>
<link href='//platform.twitter.com' rel='dns-prefetch'/>
<link href='//syndication.twitter.com' rel='dns-prefetch'/>
<base href="{{ asset('/') }}"/>
<meta name="theme-color" content="#44a3ea"/>
<meta name="robots" content="index,follow,noodp"/>
<meta name="author" content="simsogiare" />
<meta name="copyright" content="Copyright&copy;2020 simsogiare.　All Right Reserved."/>
<meta http-equiv="content-script-type" content="text/javascript"/>
<meta http-equiv="content-style-type" content="text/css"/>
<meta http-equiv="content-language" content="vi"/>
<meta name="robots" content="notranslate"/>
<link rev="made" href="mailto:support@simsogiare.com"/>
<meta name="distribution" content="global" />
<meta name="rating" content="general" />
<meta property="og:site_name" content="simsogiare"/>
<link rel="index" href="{{ asset('/') }}"/>
<script type='application/ld+json'>
{
	"@context":"https:\/\/schema.org",
	"@type":"WebSite",
	"@id":"#website",
	"url":"{{ asset('/') }}",
	"name":"simsogiare",
	"alternateName":"simsogiare",
	"potentialAction":{"@type":"SearchAction","target":"https://simsogiare.vn/search?name={search_term_string}","query-input":"required name=search_term_string"}
}
</script>
<script type='application/ld+json'>
{
	"@context":"https:\/\/schema.org",
	"@type":"Organization",
	"url":"https://simsogiare.com/",
	"foundingDate": "2020",
	"founders": [
	 {
	 "@type": "Person",
	 "name": "Author"
	 }],
	 "address": {
	 "@type": "PostalAddress",
	 "streetAddress": "Tokyo",
	 "addressLocality": "Tokyo City",
	 "addressRegion": "Tokyo",
	 "postalCode": "160-0022",
	 "addressCountry": "Japan"
	 },
	 "contactPoint": {
	 "@type": "ContactPoint",
	 "contactType": "customer support",
	 "telephone": "[+0909999999]",
	 "email": "simsogiare@gmail.com"
	 },
	"sameAs":["https:\/\/www.facebook.com\/simsogiare.tip\/"],
	"@id":"#organization",
	"name":"simsogiare",
	"logo":"https://simsogiare.com/home/logo-simsogiare.png"
}
</script>
@if(Route::current()->getName()=='home.detail')
<span itemscope itemtype='http://schema.org/Product'>
<meta itemprop='name' content='newlook'>
<meta itemprop='brand' content='Khác'>
<meta itemprop='image' content='{{ $seo['og_img'] }}'/>
<span itemprop='offers' itemscope itemtype='http://schema.org/Offer'>
<meta itemprop='priceCurrency' content='VND'/>
<meta itemprop='price' content='0'/>
<link itemprop='itemCondition' href='http://schema.org/NewCondition'/>
<link itemprop='availability' href='http://schema.org/InStock'/>
</span>
</span>
@endif