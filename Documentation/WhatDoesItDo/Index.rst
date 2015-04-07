

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


What does it do?
^^^^^^^^^^^^^^^^

This extension compiles the less files into the css file format. To
include your less file, you can use the page.includeCSS typoscript
command as usual.

This extensions uses the LessPHP compiler.

The extension comes with a cache function. That means, that the less
files will be compiled only if necessary.

You can pass values via typoscript to the less files.

