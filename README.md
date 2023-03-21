# Ext: ws_less

<img src="https://github.com/joppnet/ws_less/blob/master/ext_icon.png" width="32" height="32" />

License: [GNU GPL, Version 2](https://www.gnu.org/licenses/gpl-2.0.html)

Repository: https://github.com/svewap/ws_less

Please report bugs here: https://github.com/svewap/ws_less/issues

TYPO3 version: >8.7

## About
`ws_less` is a TYPO3 LESS compiler for compiling LESS files into CSS files. This extensions uses the `LessPHP` compiler.

The extension comes with a cache function. That means the LESS files will be compiled only if necessary.

You can pass values via TypoScript to the LESS files.

## Usage

To include your LESS file, you can use the `page.includeCSS` TypoScript command as usual.

```
page.includeCSS {
  bootstrap = fileadmin/bootstrap/less/bootstrap.less
  bootstrap.outputdir = fileadmin/bootstrap/css/

  responsive = fileadmin/bootstrap/less/responsive.less
  responsive.outputdir = fileadmin/bootstrap/css/

  rte = fileadmin/bootstrap/less/rte.less
  rte.outputdir = fileadmin/rte/css/
  rte.doNotHash = 1 # Disable file name hashing when using LESS variables via TypoScript
  rte.doNotInclude = 1 #Prevent the generated css file from being included in the frontend
}
```

You can also leave off the `outputdir` parameter. The extension will be writing the CSS files into the `typo3temp/ws_less` directory.

### Variables

You can set LESS variables in TypoScript in template setup part of your template:

```
plugin.tx_wsless.variables {
  var1 = #000
  var2 = #666
}
```

#### Disable file name hashing

For including the generated CSS files in your `ckeditor` YAML config file it is recommended to use the `doNotHash = 1` parameter. When using LESS variables the generated file will be `fileadmin/rte/css/rte.css` instead of `fileadmin/rte/css/rte_468e20047a2589981edd540b083f26c4.css` so you can easily include it in your RTE YAML config using `"contentsCss: "fileadmin/rte/css/rte.css"`

#### Disable frontend including

For compiling the less file, but not including it in the frontend, this will be useful for generating backend related css files which have no purpose in the frontend. Thus the amount of css in the frontend can be reduced.

### Development Notice

For developing it is suggested to force-render the template (switching off the TYPO3 template cache) using `admPanel.override.tsdebug.forceTemplateParsing = 1` in your backend user's UserTS config.
The LESS files will be compiled on each page load while being logged in as a backend user so you can see the result of your changes without repeatedly clearing the TYPO3 FE cache.

## Credits

- Sven Wappler ([TYPO3 Agentur Aachen](http://www.wapplersystems.de))
- Jozef Spisiak (www.pixelant.net) for optimizing the extension