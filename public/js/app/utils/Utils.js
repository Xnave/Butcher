/**
 * Created by User on 21/10/2015.
 */
function toMap(array){
    return array.reduce(function(map, obj) {
        map[obj.id] = obj;
        return map;
    }, {});
}
