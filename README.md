##TweakBlog Api 0.2

### about

This is a simple third-party library for Tweakblogs.net. As it is in very 
early development, I can't offer  many features.

Feel free to use, adapt it and please let me know if you've done something 
with it. Even if you don't want your project to be an example, it would still 
be fun for me to see it.

feedback is always appreciated

### help needed

I can't get the reaction form working. When downloading severside and sending 
clientside it doesn't work. It doesn't seem possible at first site to do it in 
javascript. (You can't use ajax to get another website) and an iframe is not ideal
at all (especially because I can not hide all irrelevant info and just show the form)

### features

current features:

	1.	get Blogs from a person
	2. 	get a Blog's content, title, description and reactions
	3.  get recent blogs
	4.	whitelist/blacklist like features
	5.	find title/description if it doesn't exist yet
	6.	temporal blog cache (every blog will now be downloaded at most once per execution)
	7.	get the time of the blogs

upcoming features

 1.	hack comment, so that you can place comments via tweakblogs.net (I need help for this one)
 
###compatibility

Works with every php version starting from 4.3.3.

needs: DOMDocument, DOMXPath, SimpleXML, Exception
 
### special thanks to

 1. general pinna.tweakblogs.be visitors.readers, who have suggested features and advised to post it on github
 2. [Sebastiaan Franken](https://github.com/sebastiaanfranken) who helped me cleaning up the code 

#### donate

If you'd like to donate (I had requests), you can send something via paypall at pinna48@gmail.com. This is absolutely not necessary
and not at all the purpose of this project. Please don't pay me when you can pay for something of better use. The software is free
and will remain free. Also you don't get any precedence in feature-requests as anyone else.
