/**
 * Helpers Functions
 */
import moment from 'moment';

// Get Date
export function getTheDate(timestamp, format) {
	let time = timestamp * 1000;
	let formatDate = format ? format : 'MM-DD-YYYY';
	return moment(time).format(formatDate);
}

// Convert Date To Timestamp
export function convertDateToTimeStamp(date, format) {
	let formatDate = format ? format : 'YYYY-MM-DD';
	return moment(date, formatDate).unix();
}

/**
 * Text Truncate
 */
export function textTruncate(str, length, ending) {
	if (length == null) {
		length = 100;
	}
	if (ending == null) {
		ending = '...';
	}
	if (str.length > length) {
		return str.substring(0, length - ending.length) + ending;
	} else {
		return str;
	}
}

/**
 * Function to convert hex to rgba
 */
export function hexToRgbA(hex, alpha) {
	var c;
	if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
		c = hex.substring(1).split('');
		if (c.length === 3) {
			c = [c[0], c[0], c[1], c[1], c[2], c[2]];
		}
		c = '0x' + c.join('');
		return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ',' + alpha + ')';
	}
	throw new Error('Bad Hex');
}

/**
 * Function to return currenr app layout
 */
export function getCurrentAppLayout(router) {
	let location = router.history.current.fullPath;
	let path = location.split("/")
	return path[1];
}

/**
 * Function to return with content width
 */
export function getWithContentWrap(drawerHeaderStt){
	var contentElement = document.getElementsByClassName('v-content__wrap')[0];
	var sidebarElement = document.getElementsByClassName('Vuely-sidebar')[0];
    var contentWidth = contentElement.clientWidth
    var sidebarWidth = sidebarElement.clientWidth

    if (contentWidth >= 1264) {
    	return (contentWidth - sidebarWidth)*30/100
    }else{
    	if (!drawerHeaderStt) {
		    if (contentWidth < 1263 && contentWidth >= 992) return contentWidth*40/100
		    else if (contentWidth < 991 && contentWidth >= 768) return contentWidth*50/100
		    else if (contentWidth < 767 && contentWidth >= 576) return contentWidth*60/100
		   	else return contentWidth
    	}else{
    		if (contentWidth < 1263 && contentWidth >= 992) return (contentWidth - sidebarWidth)*40/100
		    else if (contentWidth < 991 && contentWidth >= 768) return (contentWidth - sidebarWidth)*50/100
		    else if (contentWidth < 767 && contentWidth >= 576 )return (contentWidth - sidebarWidth)*60/100
		    else return (contentWidth - sidebarWidth)
    	}
    }
}