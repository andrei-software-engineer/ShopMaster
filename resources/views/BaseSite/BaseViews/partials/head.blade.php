<meta charset="UTF-8">
<title>{{$title}}</title>

<meta name="keywords" content="{{$metaKeyWords}}">
<meta name="description" content="{{$metaDescription}}">
<meta name="author" content="{{$metaAuthor}}">
<meta name="DC.Language" content="{{$langIndentifier}}">

<meta name="resource-type" content="document">
		 
<meta name="REVISIT-AFTER" content="1 days" />
<meta name="RATING" content="General" />
<meta name="DC.Title" content="{{$title}}" />
<meta name="DC.Format" content="text/html" />

<meta property="og:title" content="{{$title}}" />
<meta property="og:description" content="{{$metaDescription}}" />
<meta property="og:url" content="{{$canonical}}" />
<meta property="og:image" content="{{$metaImage}}" />
		
<meta property="twitter:title" content="{{$title}}" />
<meta property="twitter:description" content="{{$metaDescription}}" />
<meta property="twitter:url" content="{{$canonical}}" />
<meta property="twitter:image" content="{{$metaImage}}" />
        
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=1"/>

<link rel="canonical" href="{{$canonical}}" />
		
<link rel="shortcut icon" href="{{$favicon}}">

@include("common/commonHead")
		
@vite(['resources/sass/app.scss','resources/css/appBase.css','resources/js/app.js'])
