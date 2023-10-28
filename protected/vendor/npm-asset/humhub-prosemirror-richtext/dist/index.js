'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

var prosemirrorKeymap = require('prosemirror-keymap');
var prosemirrorHistory = require('prosemirror-history');
var prosemirrorCommands = require('prosemirror-commands');
var prosemirrorState = require('prosemirror-state');
var prosemirrorDropcursor = require('prosemirror-dropcursor');
var prosemirrorGapcursor = require('prosemirror-gapcursor');
var prosemirrorMenu = require('prosemirror-menu');
var menu_js = require('./menu.js');
var keymap_js = require('./keymap.js');
var inputrules_js = require('./inputrules.js');

// !! This module exports helper functions for deriving a set of basic
// menu items, input rules, or key bindings from a schema. These
// values need to know about the schema for two reasons—they need
// access to specific instances of node and mark types, and they need
// to know which of the node and mark types that they know about are
// actually present in the schema.
//
// The `exampleSetup` plugin ties these together into a plugin that
// will automatically enable this basic functionality in an editor.

// :: (Object) → [Plugin]
// A convenience plugin that bundles together a simple menu with basic
// key bindings, input rules, and styling for the example schema.
// Probably only useful for quickly setting up a passable
// editor—you'll need more control over your settings in most
// real-world situations.
//
//   options::- The following options are recognized:
//
//     schema:: Schema
//     The schema to generate key bindings and menu items for.
//
//     mapKeys:: ?Object
//     Can be used to [adjust](#example-setup.buildKeymap) the key bindings created.
//
//     menuBar:: ?bool
//     Set to false to disable the menu bar.
//
//     history:: ?bool
//     Set to false to disable the history plugin.
//
//     floatingMenu:: ?bool
//     Set to false to make the menu bar non-floating.
//
//     menuContent:: [[MenuItem]]
//     Can be used to override the menu content.
function exampleSetup(options) {
  var plugins = [
    inputrules_js.buildInputRules(options.schema),
    prosemirrorKeymap.keymap(keymap_js.buildKeymap(options.schema, options.mapKeys)),
    prosemirrorKeymap.keymap(prosemirrorCommands.baseKeymap),
    prosemirrorDropcursor.dropCursor(),
    prosemirrorGapcursor.gapCursor()
  ];
  if (options.menuBar !== false)
    { plugins.push(prosemirrorMenu.menuBar({floating: options.floatingMenu !== false,
                          content: options.menuContent || menu_js.buildMenuItems(options.schema).fullMenu})); }
  if (options.history !== false)
    { plugins.push(prosemirrorHistory.history()); }

  return plugins.concat(new prosemirrorState.Plugin({
    props: {
      attributes: {class: "ProseMirror-example-setup-style"}
    }
  }))
}

exports.buildMenuItems = menu_js.buildMenuItems;
exports.buildKeymap = keymap_js.buildKeymap;
exports.buildInputRules = inputrules_js.buildInputRules;
exports.exampleSetup = exampleSetup;
//# sourceMappingURL=index.js.map
