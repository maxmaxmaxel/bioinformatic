# bioinformatic
retrieve pubmed abstract with Entrez programming interface 

#Quick start
  install PHP and apache2 
    Upload all file to your web folder (e.g. XAMPP ./htdocs/ or ubunu /var/www/html/ )
  then 
    start apache2 
#on Ubuntu
    sudo service apache2 restart   

#main component    
#file demo.php => main website
#file getweb.php => logic to find pubmed paper by using entrez programming interface
#file simple_html_dom.php refer to http://simplehtmldom.sourceforge.net/
#not directly relate to project file readjson.php => this part is for retrieve name of RNA from ftp://ftp.ebi.ac.uk/pub/databases/genenames/new/json/locus_types/RNA_ribosomal.json


#Entrez programming reference : http://www.ncbi.nlm.nih.gov/books/NBK25501/
#Entrez programming reference : http://www.ncbi.nlm.nih.gov/books/NBK25500/
