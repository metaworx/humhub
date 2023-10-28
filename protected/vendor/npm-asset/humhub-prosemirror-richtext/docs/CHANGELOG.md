1.0.9 (August 30, 2018)
-----------------------------------------
- Enh: Use of file-guid for uploaded images and files
- Enh: Paste images from clipboard
- Fix: Image edit button not removed correctly
- Fix: Missing addition check for plugin existance in `addPluginToPreset`
- Enh: Added `link.options.validate` function to intercept link input validation

1.0.8 (July 24, 2018)
-----------------------------------------
- Chng: Use of relative upload url

1.0.6 (July 30, 2018)
-----------------------------------------
- Fix: `context.getPluginOption()` default always overwrites actual option
- Chng: Added `code` mark to default visible elements

1.0.5 (July 18, 2018)
-----------------------------------------
- Fix: File upload errors not handled

1.0.4 (July 17, 2018)
-----------------------------------------
- Fix: table options padding issue
- Fix: dropdown menu position not aligned
- Enh: updated prosemirror dependencies
- Enh: added image edit by inline edit on hover
- Enh: added link edit by click
- Fix: emoji autocompplete and emoji input rule fired without leading space
- Chng: render `data-contentcontainer-guid` instead of `data-guid` for mentionings
- Enh: allow `mailto:` and `ftp:` url
- Enh: added email paste regex to linkify util
- Enh: added maxHeigt richtext plugin
- Enh: added promt form labels
