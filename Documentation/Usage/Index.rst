.. include:: Images.txt

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Usage
-----

Use the includeCSS command and define the output dir:

::

   page.includeCSS {
   
     bootstrap = fileadmin/bootstrap/less/bootstrap.less
     bootstrap.outputdir = fileadmin/bootstrap/css/
     
     responsive = fileadmin/bootstrap/less/responsive.less
     responsive.outputdir = fileadmin/bootstrap/css/
   
   }

You can also leave off the  *outputdir* . Then the extension writes
the css files into the typo3temp/ws\_less dir.

Variables: You can set less variables in typoscript in template setup
part of your template:

::

   plugin.tx_wsless.variables {
     var1 = #000
     var2 = #666
   }

For developing it is practical, if you force to render the template
(switch off the TYPO3 template cache). Then the less files will be
compiled after modification and you can see the result of your
changes. Go into your backend user settings and use this command:

|img-3|


Credits
-------

Sven Wappler. `TYPO3 Agentur Aachen <http://www.wapplersystems.de/>`_

Special thank to Jozef Spisiak from `www.pixelant.net
<http://www.pixelant.net/>`_ for optimizing the extension.


