# atos
Sips-International Worldline plugin for Magix cms

![Plugin Atos Magix CMS](http://worldline.com/etc/designs/neoweb/images/images-wl/worldline-logo.jpg "Plugin Atos pour Magix CMS")

### version 

[![release](https://img.shields.io/github/release/magix-cms/atos.svg)](https://github.com/magix-cms/atos/releases/latest)

Authors
-------

* Gerits Aurelien (aurelien[at]magix-cms[point]com)

## Description
Ce plugin est dédié a Magix CMS et travail avec Worldline Sips (Atos).

## Installation
 * Décompresser l'archive dans le dossier "plugins" de magix cms
 * Connectez-vous dans l'administration de votre site internet
 * Cliquer sur l'onglet plugins du menu déroulant pour sélectionner Atos.
 * Une fois dans le plugin, laisser faire l'auto installation
 * Il ne reste que la configuration du plugin pour correspondre avec vos données.
 
 #### Exemple d'utilisation dans votre panier
 **Préparer les données a envoyer :**
  ```php
  $brand = $_POST['brand'];
  $atos = new plugins_atos_public();
  if(isset($brand)){
      $getPaymentRequest = $atos->getPaymentRequest(array(
          'returnUrl'           =>  'atos',
          'iso'                 =>  frontend_model_template::current_Language(),
          'brand'               =>  'VISA',
          'amount'              =>  '1000',
          'orderId'             =>  'ds5f4f45sf456d4',
          'customerId'          =>  '4',
          'customerEmail'       =>  'test@mail.com',
          'returnContext'       =>  '10'
      ));
      $this->template->assign('getItemData', $getPaymentRequest, true);
  }else{
      // Affiche les modes de paiements disponible.
      $atos->getPaymentBrand();
  }
 ````
 **Utiliser les données reçues :**
 ```php
   $atos = new plugins_atos_public();
   if(isset($_POST['Encode'])){
       $setData = $atos->fetchData(array('context'=>'unique'));
       $data = $atos->getPaymentResponse($setData);
       $this->template->assign('getPaymentResponse', $data, true);
   }else{
       $atos->getPaymentBrand();
   }
  ````
 
  Ressources
  -----
   * http://fr.worldline.com
   * http://www.magix-cms.com
 
