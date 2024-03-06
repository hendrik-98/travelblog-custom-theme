#Travelblog Custom Theme
Das Theme umfasst 2 Custom Posttypes namens Hotels und Events.
Hotels und Events haben die Taxonomy Destinations. 

Für die Posttypes gibt es jeweils eine Archive Seite.
Hotels hat den slug /hotels. Auf der Hotels Seite kann man nach Sterne und Destination filtern.
Events hat den slug /events. Auf der Events Seite kann man nach Datum und Destination filtern.

Für die Taxonomy Destinations gibt es auch ein Archiv. Der Slug ist /destination/<term>  (z.B. /destination/paris)
Man kann die Beiträge nach Sterne oder Datum filtern.

Der Content der Beiträge ist mit dem Gutenbergeditor, custom fields, shortcodes und plugins umgesetzt.
Custom Fields wurden ohne ein Plugin erstellt, da es nur zwei Felder gab (Sterne und Datum).
Der Shortcode wurde erstellt, um das Youtube Video einzubinden. Der Shortcode muss so verwendet werden:
[youtube_video url="https://www.youtube.com/watch?v=VIDEO_ID"]

Es kann um die optionale Galerie mit Slideshow und einer Lightbox zu nutzen das Plugin Lightbox for Gallery & Image Block (https://de.wordpress.org/plugins/gallery-block-lightbox/) genutzt werden. Nach dem Installieren funktioniert die Wordpress Standart Galerie wie gewollt.

Zum einfachen Erstellen der Beiträge habe ich für Hotels und auch Events eine Vorlage erstellt, die man im Gutenbergeditor finden kann. (Hotels Vorlage und Events Vorlage)

Mein Vorgehen beim Erstellen kann man gut Anhand meiner Git History verfogen. Hier gehts zum Repository (https://github.com/hendrik-98/travelblog-custom-theme/)
Ich habe mit Docker gearbeitet. In meinem Docker Container ist ein apache webserever mit WordPress, phpmyadmin und mysql installiert.

##Installation
Die ZIP-Datei mit dem Theme, der Datenbank und den Uploads habe ich auch nocheinmal im Git hinterlegt.(https://github.com/hendrik-98/travelblog-custom-theme/releases/download/wordpress-theme/travel-blog-hendrik-egbers.zip)

###Das Theme
Das angepasste Theme für die Coding Challenge heißt travelblog-custom-theme.

###Die Datenbank
Ich habe die Datenbank als SQL Datei im Ordner Datenbank hinterlegt.

###Die Mediadatein
Ich habe die Uplaods im Ordner Uplaods hinterlegt.

###Sonstige Datien
Für den Fall, das es ein Problem gibt, mit den Test Beiträgen habe ich eine XML Datei für den Wordpress Importer im Ordner wordpress-export hinterlegt.

