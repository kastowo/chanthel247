function defaultModel(defaultModel)
{
    var Model =  Backbone.Model.extend({
        defaults: defaultModel
    });
    return (new Model());
}

function newModelParsed(defaultModel)
{
    var Model =  Backbone.Model.extend({
         defaults: JSON.parse(defaultModel)
    });
    return (new Model());
}