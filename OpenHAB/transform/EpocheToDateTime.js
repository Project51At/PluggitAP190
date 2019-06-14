//
//	@author			Helge Klug
//	@copyright		Copyright (c) 2018 Helge Klug
//	@version		1.10
//	@brief			Transform epoch to datetime
(function(i) {
    var date = new Date(i * 1000);
    return date.toISOString();
})(input)