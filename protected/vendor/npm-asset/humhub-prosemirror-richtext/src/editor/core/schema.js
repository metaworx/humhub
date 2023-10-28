/*
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

import {Schema} from "prosemirror-model"
import {PresetManager} from "./plugins/"

let mergeSchema = function(schema, plugin) {
    if(Array.isArray(plugin)) {
        plugin.forEach((newPlugin) => {
            schema = mergeSchema(schema, newPlugin)
        })
    } else {
        schema.nodes = Object.assign(schema.nodes || {}, plugin.schema && plugin.schema.nodes || {});
        schema.marks = Object.assign(schema.marks || {}, plugin.schema && plugin.schema.marks || {});
    }

    return schema;
};

let presets = new PresetManager({
    name: 'schema',
    create: (context) => {
        return new Schema(mergeSchema({}, context.plugins));
    }
});

let getSchema = function(context) {
    return presets.check(context);
};

export {getSchema};