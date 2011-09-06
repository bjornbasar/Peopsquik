window.addEvent('domready', function()
{
	// autoload of form validators
	addValidators();

	$$('input, textarea').each(function(el)
	{
		AUSTRAL.overtext.push(new OverText(el, {
			element: 'div',
			wrap: true,
			poll: true
		}));
	});

	// menu
	new UvumiDropdown('mainmenu', {
		clickToOpen: true
	});

	AUSTRAL.growl = new Notimoo();

	// keepalive
	AUSTRAL.keepalive = new Request({
		url: URLS.keepAlive,
		method: 'get',
		initialDelay: 30000,
		delay: 10000,
		limit: 300000
	}).startTimer();

});

function doCall(callmethod, callurl, data)
{
	new Request(
	{
		url: callurl,
		method: callmethod
	}).send(data);
}

function growl(growlmessage)
{
	AUSTRAL.growl.show({title: 'Notification', message: growlmessage});
}

function addValidators()
{
	$$('form').each(function(el)
	{
		var fv = new Form.Validator(el,
		{
			stopOnFailure: true,
			evaluateOnSubmit: true,
			evaluateFieldsOnBlur: true,
			evaluateFieldsOnChange: true,
			onElementFail: function(el, errors)
			{
				var fv = this;
				var errorMsg = '';
				errors.each(function(error)
				{
					errorMsg += fv.validators[error].getError(el, fv.validators[error].getProps(el)) + "<br/>\n";
				});

				var errorTxt = new Element('div', {
				'class': 'error'
				});
				errorTxt.innerHTML = errorMsg;
				errorTxt.injectAfter(el);

				errorTxt.position({
					relativeTo: el
				});


				var elId = el.get('id');				
				var nextDiv = $(elId).getNext('div');
				
				// This is for adsource
				if(elId == 'adsource')
				{
					$('adsource').addEvent('focus', function(){						
						nextDiv.destroy();
					});
				}
				else
				{
					$(elId).addEvent('keyup', function(){
						nextDiv.destroy();
					});
				}

				/*
				setTimeout(function()
				{
				$$('.error').each(function(el)
				{
				el.tween('height', 0);
				setTimeout(function()
				{
				el.destroy();
				}, 2000);
				});
				}, 3000);

				*/
				setTimeout(function()
				{
					AUSTRAL.hasError = false;
				}, 500);
				if (!AUSTRAL.hasError)
				{
					//					el.focus();
					AUSTRAL.hasError = true;
				}

			}
		});
		el.store('validator', fv);
	});


}

function disableForm(formid)
{
	OverText.hideAll();
	$$('#' + formid + ' input, #' + formid + ' select, #' + formid + ' textarea').each(function(el)
	{
		el.set('disabled', true);
	});
}

function submitForm(formid)
{
	var fv = $(formid).retrieve('validator');
	if (fv)
	{
		var result = fv.validate();
		if (result)
		{
			$(formid).submit();
		}
	}
	else
	{
		$(formid).submit();
	}
}

function showSegmentSimulator(segment)
{
	$$('.simulatorElement').each(function(el)
	{
		if (el.lang != segment)
		{
			el.hide();
		}
		else
		{
			el.show();
		}
	});
}

function nextSegmentSimulator()
{
	var current = +$('currentSegment').value;
	var segments = +$('segments').value;

	var pass = true;
	var test = new Elements;
	Slick.search($('simulatorForm'), 'p[lang="' + current + '"] input, p[lang="' + current + '"] select, p[lang="' + current + '"] textarea, ', test).each(function(el)
	{
		if (!$('simulatorForm').retrieve('validator').validateField(el.id, true))
		{
			pass = false;
		}
	});

	if (current < segments && pass)
	{
		showSegmentSimulator(current + 1);
		$('currentSegment').value = current + 1;

		checkButtonsSimulator(current + 1);
	}
}

function backSegmentSimulator()
{
	var current = +$('currentSegment').value;

	var pass = true;
	var test = new Elements;
	Slick.search($('simulatorForm'), 'p[lang="' + current + '"] input, p[lang="' + current + '"] select, p[lang="' + current + '"] textarea, ', test).each(function(el)
	{
		if (!$('simulatorForm').retrieve('validator').validateField(el.id, true))
		{
			pass = false;
		}
	});

	if (current > 1 && pass)
	{
		showSegmentSimulator(current - 1);
		$('currentSegment').value = current - 1;

		checkButtonsSimulator(current - 1);
	}
}

function checkButtonsSimulator(current)
{
	var segments = +$('segments').value;

	if ((current) >= segments)
	{
		$('submitButton').setStyle('display', 'inline');
		$('nextButton').setStyle('display', 'none');
	}
	else
	{
		$('submitButton').setStyle('display', 'none');
		$('nextButton').setStyle('display', 'inline');
	}

	if (current <= 1)
	{
		$('backButton').setStyle('display', 'none');
	}
	else
	{
		$('backButton').setStyle('display', 'inline');
	}

}

function updateCalendar(personnelid)
{
	new Request.JSON({
		url: URLS.getSchedule + '/' + personnelid,
		onSuccess: function(caldata)
		{
			$('container').innerHTML = '';
			AUSTRAL.personnelCalendar = new mooCal({
				container: 'container',
				monthHeaderClass: 'monthHeader',
				prevClass: 'click',
				nextClass: 'click',
				data: caldata,
				onClick: function(day, el)
				{
					new Request.JSON({
						url: URLS.getTimeSchedule + '/' + personnelid + '/' + day,
						onSuccess: function(timedata)
						{
							var y = new mooDay({
								container: 'daycontainer',
								date: day,
								startTime: AUSTRAL.startTime,
								endTime: AUSTRAL.endTime,
								data: timedata,
								onClick: function(date, time, text, id)
								{
									AUSTRAL.currentLightBox = new mooLB({
										url: 'partial_personnel_schedule_edit/' + $('personnel_id').value + '/' + id + '/' + date + '/' + time,
										width: 700,
										height: 600,
										overlayOpacity: 0.5,
										overlayColor: '#ccc'
									});
								}
							});
						}
					}).send();
				}
			});
		}
	}).send();
}

function updateEquipmentCalendar(equipmentid)
{
	new Request.JSON({
		url: URLS.getEquipSchedule + '/' + equipmentid,
		onSuccess: function(caldata)
		{
			$('container').innerHTML = '';
			AUSTRAL.personnelCalendar = new mooCal({
				container: 'container',
				monthHeaderClass: 'monthHeader',
				prevClass: 'click',
				nextClass: 'click',
				data: caldata,
				onClick: function(day, el)
				{
					new Request.JSON({
						url: URLS.getEquipTimeSchedule + '/' + equipmentid + '/' + day,
						onSuccess: function(timedata)
						{
							var y = new mooDay({
								container: 'daycontainer',
								date: day,
								startTime: AUSTRAL.startTime,
								endTime: AUSTRAL.endTime,
								data: timedata,
								onClick: function(date, time, text, id)
								{
									AUSTRAL.currentLightBox = new mooLB({
										url: 'partial_equipment_maintenance_edit/' + $('equipment_id').value + '/' + id + '/' + date + '/' + time,
										width: 700,
										height: 600,
										overlayOpacity: 0.5,
										overlayColor: '#ccc'
									});
								}
							});
						}
					}).send();
				}
			});
		}
	}).send();
}

function getSelectedDayCalendar(container)
{
	var selectedDay;
	$$('#' + container + ' .selected span').each(function(el)
	{
		selectedDay = +el.get('text');
	});

	return selectedDay;
}

function getSelectedDateCalendar(field)
{
	var currentdate = '';
	new Request.JSON({
		url: CONFIG.baseurl + 'dateConvert.json/' + AUSTRAL.personnelCalendar.calDate,
		onSuccess: function(data)
		{
			$(field).value = data;
			validateDates();
		}
	}).send();
}

function validateDates()
{
	new Request({
		url: CONFIG.baseurl + 'validatedates.json/' + $('personnel_id').options[$('personnel_id').selectedIndex].value + '/' + $('datestart').value + '/' + $('dateend').value,
		onSuccess: function(data)
		{
			if (data > 0)
			{
				$('datestart').value = '';
				$('dateend').value = '';
				alert('Schedule has conflicts.');
			}
		}

	}).send();
}

function validateEquipDates()
{
	new Request({
		url: CONFIG.baseurl + 'validateEquipDates.json/' + $('equipment_id').options[$('equipment_id').selectedIndex].value + '/' + $('datestart').value + '/' + $('dateend').value,
		onSuccess: function(data)
		{
			if (data > 0)
			{
				$('datestart').value = '';
				$('dateend').value = '';
				alert('Schedule has conflicts.');
			}
		}

	}).send();
}

function checkScheduleBySelectedDate()
{
	new Request.JSON({
		url: CONFIG.baseurl + 'dateConvert.json/' + AUSTRAL.personnelCalendar.calDate,
		onSuccess: function(data)
		{
			checkSchedule(data);
		}
	}).send();
}

function checkSchedule(data)
{
	new Request.JSON({
		url: CONFIG.baseurl + 'checkschedule.json/' + $('personnel_id').options[$('personnel_id').selectedIndex].value + '/' + data,
		onSuccess: function(data)
		{
			if (data.datestart)
			{
				$('datestart').set('value', data.datestart);
				$('dateend').set('value', data.dateend);
				$('personnelschedule_id').set('value', data.personnelschedule_id);
			}
		}
	}).send();
}

function convertDate(date)
{
	var t = new Date();
	t.parse(date);
	return t.format('%d-%m-%Y');
}

function convertDate2(date)
{
	var t = new Date();
	t.parse(date);
	return t.format('%Y-%m-%d');
}

function submitSimulator(pars)
{
	new Request({
		url: URLS.jobEdit,
		method: 'POST',
		onSuccess: function(response)
		{
			location.href = URLS.jobForm + '/' + $('jobcategories_id').value + '/' + $('customerName').value + '/' + response;
		}
	}).send(pars);
}

function parseAnswers(data)
{
	data.each(function(answer)
	{
		if (answer.value.search(/\|\|/i) >= 0)
		{
			var answers = answer.value.split('||');
			answer.value = answers[0];
			$('billing_' + answer.id).set('value', answers[1]);
		}

		if (answer.id && $(answer.id))
		{
			$(answer.id).set('value', answer.value);
		}

		$$('#' + answer.id + " span input").each(function(el)
		{

			if(el.value == answer.value)
			{
				el.checked = true;
			}

			if (answer.value.indexOf('["') == 0 && answer.value.indexOf('"]') == (answer.value.length - 2))
			{
				var jsonStr = JSON.parse(answer.value);
				jsonStr.each(function(ans)
				{
					if(el.value == ans)
					{
						el.checked = true;
					}
				});
			}

		});
	});
}

function jobcategoryformorderrefresh()
{
	var order = '';
	$$('#selectedForm li').each(function(el)
	{
		order += el.title + ',';
	});
	$('jobcategoryformorder').value = order;
}

function updateJobCalendar(jobid)
{
	new Request.JSON({
		url: URLS.getJobSchedule,
		onSuccess: function(caldata)
		{
			$('container').innerHTML = '';
			AUSTRAL.personnelCalendar = new mooCal({
				container: 'container',
				monthHeaderClass: 'monthHeader',
				prevClass: 'click',
				nextClass: 'click',
				data: caldata,
				onClick: function(day, el)
				{
					$('listcontainer').load(URLS.jobScheduleList + '/' + day);
				}
			});
		}
	}).send();
}

function customerShowMap()
{
	// construct address
	var address = $('street').get('value') + ', ' + $('suburb').get('value') + ', ' + $('state').get('value');

	AUSTRAL.currentLightBox = new mooLB({
		url: 'partial_customer_map/' + address,
		width: 720,
		height: 360,
		overlayOpacity: 0.5,
		overlayColor: '#ccc'
	});
}

function siteShowMap()
{
	// construct address
	var address = $('site_street').get('value') + ', ' + $('site_suburb').get('value') + ', ' + $('site_state').get('value');

	AUSTRAL.currentLightBox = new mooLB({
		url: 'partial_site_map/' + address,
		width: 720,
		height: 360,
		overlayOpacity: 0.5,
		overlayColor: '#ccc',
		zindex: 11000
	});
}

function jobShowMap()
{
	// construct address
	if ($('simulator_4').get('value') != '' && $('simulator_5').get('value') != '' && $('simulator_6').get('value') != '')
	{
		var address = $('simulator_4').get('value') + ', ' + $('simulator_5').get('value') + ', ' + $('simulator_6').get('value');
	}
	else
	{
		var address = '';
	}

	AUSTRAL.currentLightBox = new mooLB({
		url: 'partial_job_formmap/' + address,
		width: 720,
		height: 360,
		overlayOpacity: 0.5,
		overlayColor: '#ccc'
	});
}

function showMap(id)
{
	// construct address
	if ($(id) && $(id).value)
	{
		var address = $(id).get('value');
	}
	else
	{
		var address = '';
	}

	AUSTRAL.currentLightBox = new mooLB({
		url: 'partial_job_map/' + id + '/' + address,
		width: 720,
		height: 360,
		overlayOpacity: 0.5,
		overlayColor: '#ccc'
	});
}

function loadListEdit(lists_id, listdata_id)
{
	var editurl = 'partial_forms_lists_edit/' + lists_id + '/';
	if (listdata_id != null)
	{
		editurl += listdata_id;
	}

	AUSTRAL.currentLightBox = new mooLB({
		url: editurl,
		width: 700,
		height: 200,
		overlayOpacity: 0.5,
		overlayColor: '#ccc'
	});

}

function loadPartial(partialurl)
{
	AUSTRAL.currentLightBox = new mooLB({
		url: partialurl,
		width: 700,
		height: 600,
		overlayOpacity: 0.5,
		overlayColor: '#ccc'
	});
}

var memberIDs = [];
var equipmentIDs = [];
var dateStart;
var dateEnd;
var timeStart;
var timeEnd;

function updateJobSchedulingForm()
{

	var teamID = $('teams_id').getSelected().get("value");

	if(teamID != 0)
	{
		$('hiddenTeams_id').value = $('teams_id').get('value');
		$('selectedTeamBox').tween('display', 'block');
		$('selectedEquipmentBox').tween('display', 'block');

		dateStart = $('datestart').value;
		dateEnd = $('dateend').value;
		timeStart = $('timestart').value;
		timeEnd = $('timeend').value;

		new Request.JSON({
			url: CONFIG.baseurl+ 'getTeamMembers.json/' + teamID + '/' + dateStart + '/' + timeStart + '/' + dateEnd + '/' + timeEnd,
			onSuccess: function(members)
			{

				$('selectedForm').empty();
				memberIDs.empty();

				members.each(function(member){
					var classname = 'available';
					if (!member.available)
					{
						classname = 'unavailable';
					}
					var memberInfo = new Element('li', {'text': member.lastname + ', ' + member.firstname, 'title': member.personnel_id, 'class': classname}).injectInside($('selectedForm'));


					var dlteButton = new Element('span', {
					'class'	: 'dltbtn',
					'text'	: 'Delete'
					});

					dlteButton.injectInside(memberInfo);

					jobScheduleDeleteClick();

					memberIDs.push(member.personnel_id);
					$('hidden').set('value', memberIDs);

				});

				jobScheduleAddClick();

			}
		}).send();

		new Request.JSON({
			url: CONFIG.baseurl+ 'getTeamEquipment.json/' + teamID + '/' +  dateStart + '/' + timeStart + '/' + dateEnd + '/' + timeEnd,
			onSuccess: function(equipments)
			{

				$('selectedEquipmentList').empty();
				equipmentIDs = [];

				equipments.each(function(equipment){
					var classname = 'available';
					if (!equipment.available)
					{
						classname = 'unavailable';
					}
					var equipmentInfo = new Element('li', {'text': equipment.name, 'title': equipment.equipment_id, 'class': classname}).injectInside($('selectedEquipmentList'));

					var dlteButton = new Element('span', {
					'class'	: 'dltbtnEQ',
					'text'	: 'Delete'
					});

					dlteButton.injectInside(equipmentInfo);

					jobScheduleEqDeleteClick();

					equipmentIDs.push(equipment.equipment_id);
					$('hiddenEq').set('value', equipmentIDs);
				});

				jobScheduleEqAddClick();
			}
		}).send();
	}
	else
	{
		$('selectedTeamBox').tween('display', 'none');
		$('selectedEquipmentBox').tween('display', 'none');
	}

	$('teams_id').selectedIndex = 0;
}

function jobScheduleDeleteClick()
{
	$$('.dltbtn').each(function(el){
		el.addEvent('click', function()
		{
			var id = this.getParent().get('title');

			this.getParent().destroy();

			var temp = memberIDs;

			memberIDs = [];

			temp.each(function(memberid)
			{
				if (memberid != id)
				{
					memberIDs.push(memberid);
				}
			});

			$('hidden').set('value', memberIDs);
		});
	});
}

function jobScheduleAddClick()
{
	$('addMember').addEvent('click', function(e){

		var memberValue = $('member_id').getSelected().get("value");

		var exists = false;

		memberIDs.each(function(el)
		{
			if (el == memberValue)
			{
				exists = true;
			}
		});

		if(memberValue != 0 && !exists)
		{
			var classname = 'available';
			new Request.JSON({
				url: CONFIG.baseurl+ 'validateTeamMembers.json/' + memberValue + '/' +  dateStart + '/' + timeStart + '/' + dateEnd + '/' + timeEnd,
				onSuccess: function(available)
				{
					if (!available)
					{
						classname = 'unavailable';
					}
				}
			}).send();

			var addMember = new Element('li', {'text': $('member_id').getSelected().get("text"), 'title': memberValue, 'class': classname});

			var dlteButton = new Element('span', {
			'class'	: 'dltbtn',
			'text'	: 'Delete'
			});

			addMember.injectInside('selectedForm')

			dlteButton.injectInside(addMember);

			jobScheduleDeleteClick();

			memberIDs.push(+memberValue + '');
			$('hidden').set('value', memberIDs);
		}

		$('member_id').selectedIndex = 0;

	});
}

function jobScheduleEqDeleteClick()
{
	$$('.dltbtnEQ').each(function(el){
		el.addEvent('click', function()
		{
			var id = this.getParent().get('title');

			this.getParent().destroy();

			var tempEqID = equipmentIDs;

			equipmentIDs = [];

			tempEqID.each(function(equipmentid)
			{
				if (equipmentid != id)
				{
					equipmentIDs.push(equipmentid);
				}
			});

			$('hiddenEq').set('value', equipmentIDs);

		});
	});
}


function jobScheduleEqAddClick()
{
	$('addEquipment').addEvent('click', function(e){

		var equipmentValue = $('equipment_id').getSelected().get("value");

		var exists = false;

		equipmentIDs.each(function(el)
		{
			if (el == equipmentValue)
			{
				exists = true;
			}
		});

		if(equipmentValue != 0 && !exists)
		{
			var classname = 'available';
			new Request.JSON({
				url: CONFIG.baseurl+ 'validateTeamEquipment.json/' + equipmentValue + '/' +  dateStart + '/' + timeStart + '/' + dateEnd + '/' + timeEnd,
				onSuccess: function(available)
				{
					if (!available)
					{
						classname = 'unavailable';
					}
				}
			}).send();

			var addEquipment = new Element('li', {'text': $('equipment_id').getSelected().get("text"), 'title': equipmentValue, 'class': classname});

			var dlteButton = new Element('span', {
			'class'	: 'dltbtnEQ',
			'text'	: 'Delete'
			});

			addEquipment.injectInside('selectedEquipmentList')

			dlteButton.injectInside(addEquipment);

			jobScheduleEqDeleteClick();

			equipmentIDs.push(+equipmentValue + '');
			$('hiddenEq').set('value', equipmentIDs);
		}

		$('equipment_id').selectedIndex = 0;
	});
}

function jobScheduleRefreshIDs()
{
	// selectedForm
	$$('#selectedForm li').each(function(e)
	{
		memberIDs.push(+e.get('title') + '');
	});

	// selectedEquipmentList
	$$('#selectedEquipmentList li').each(function(e)
	{
		equipmentIDs.push(+e.get('title') + '');
	});

	$('hiddenEq').set('value', equipmentIDs);
	$('hidden').set('value', memberIDs);
}

var customermap;
var customermappoints = [];
var timer;
var customermaptip = {};
var mousex;
var mousey;
var markercluster;
var mcOptions = {gridSize: 40, maxZoom: 15};

customermaptip.reposition = function(e)
{
	if (document.width - (mousex + 200) < 20)
	{
		customermaptip.tip.setStyle('left', mousex - 200 - 10 - (10 * 2));
	}
	else
	{
		customermaptip.tip.setStyle('left', mousex + 10);
	}
	customermaptip.tip.setStyle('top', mousey - (270 + 20));
}

function customerMap()
{
	var coords = {"status":true, "lat":-34.948302, "lng":138.644582};

	customermap = new google.maps.Map($('customer_map'), {
		zoom: 12,
		streetViewControl: false,
		mapTypeControl: false,
		center: new google.maps.LatLng(coords.lat, coords.lng),
		scrollwheel: false,
		zoomControl: false,
		mapTypeId: google.maps.MapTypeId.HYBRID
	});

	window.addEvent('load', function()
	{
		google.maps.event.addListenerOnce(customermap, 'tilesloaded', function(event)
		{
			customerMapUpdate();
		});
		google.maps.event.addListenerOnce(customermap, 'idle', function(event)
		{
			customerMapUpdate();
		});
		
		customerMapUpdate();
		google.maps.event.addListener(customermap, 'dragend', function(event)
		{
			customerMapUpdate();
		});
		google.maps.event.addListener(customermap, 'zoom_changed', function(event)
		{
			customerMapUpdate();
		});

	});

}

//google.maps.event.addListenerOnce(customermap, 'idle', function(event)
//{
//	customerMap();
//});

function customerMapUpdate()
{
	new Request.JSON({
		url: URLS.customerByBounds + '/' + customermap.getBounds().toUrlValue(),
		onSuccess: function(customers)
		{
			customerMapClearMarkers();
			customers.each(function(el)
			{
				customerMapAddPoint(el.lat, el.lng, el.name, el);
			});

			markercluster = new MarkerClusterer(customermap, customermappoints, mcOptions);
		}
	}).send();
}

function customerMapClearMarkers()
{
	customermappoints.each(function(el)
	{
		el.setMap(null);
	});
	if (markercluster)
	{
		markercluster.clearMarkers();
	}
}

function customerMapAddPoint(lat, lng, title, data)
{
	var myLatlng = new google.maps.LatLng(lat, lng);

	var tree = new google.maps.MarkerImage('includes/tree.png');

	if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)))
	{
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: customermap,
			title: title
		});
	}
	else
	{
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: customermap,
			icon: tree,
			title: title
		});
	}

	customermappoints[customermappoints.length] = marker;

	document.onmousemove = getmousexy;

	google.maps.event.addListener(marker, 'mouseover', function(e)
	{
		if (!customermaptip.tip)
		{
			customermaptip.tip = new Element('div', {
				id: 'mooTips_tip',
				'class': 'mooLB',
				styles: {
					position: 'fixed',
					width: 200,
					height: 270,
					padding: 10,
					'z-index': 9001,
					'background-color': '#cccccc'
				}
			});

			customermaptip.tip.injectInside(document.body);

			customermaptip.tipContent = new Element('div',{
				id: 'mooTips_content',
				'class': 'mooLBContent',
				styles: {
					width: (200 - 10),
					height: (270 - 10),
					overflow: 'hidden',
					'background-color': '#fff',
					padding: '5px'
				}
			});

			customermaptip.tipContent.injectInside(customermaptip.tip);

			// position tooltip here
			customermaptip.reposition(e);

			customermaptip.tipContent.load('partial_customer_info/' + data.customers_id);
		}
	});

	google.maps.event.addListener(marker, 'mouseout', function(e)
	{
		if (customermaptip.tip)
		{
			customermaptip.tip.destroy();
			customermaptip.tip = null;
		}
	});

}

function getTotals()
{
	$('totalCosts').value = 0;
	var elems = $('simulatorForm').getElements('*[id^=billing_simulator]');
	elems.each(function(el)
	{
		$('totalCosts').value = +$('totalCosts').value + +$(el.id.substr(8)).value * +el.value;
	});
}

function getmousexy(e)
{
	mousex = e.clientX;
	mousey = e.clientY;
}

function autoCompleteDropdownEquip(inputName, tblName, fldName, urlJSON, selectedDate)
{
	new Autocompleter.Request.JSON(inputName, urlJSON + '/' + tblName + '/' + fldName + '/' +  inputName + '/' + selectedDate , {
	'postVar': inputName,
	minLength: 1,
	maxChoices: 15,
	autoSubmit: false,
	cache: false,
	forceSelect: true,
	delay: 1,
	filterCase : true,
	onRequest: function() {
		$(inputName).setStyles({
		'background-image':'url('+ CONFIG.baseurl +'/includes/indicator_blue_small.gif)',
		'background-position':'center right',
		'background-repeat':'no-repeat'
		});
	},
	onComplete: function(t1,t2) {
		$(inputName).setStyle('background','');
	},
	onSelection: function(element, selected, hiddenvalue, input) {
		new Request.JSON({
			url: URLS.autoReturnFleetNameID + '/' + hiddenvalue,
			onSuccess: function(valueID)
			{
				$(element.id.substr(5, element.id.length)).set('value', valueID);
			}
		}).send();
	}
	});
}

function autoCompleteDropdown(inputName, tblName, fldName, urlJSON, length, max, force, onselection)
{
	if(length === undefined) { length = 3; }
	if(max === undefined) { max = 50; }
	if(force === undefined) { force = true; }
	new Autocompleter.Request.JSON(inputName, urlJSON + '/' + tblName + '/' + fldName + '/' +  inputName, {
	'postVar': inputName,
	minLength: length,
	maxChoices: max,
	autoSubmit: false,
	cache: false,
	forceSelect: force,
	delay: 0,
	filterCase : true,
	onSelection: onselection,
	onRequest: function() {
		$(inputName).setStyles({
		'background-image':'url('+ CONFIG.baseurl +'/includes/indicator_blue_small.gif)',
		'background-position':'center right',
		'background-repeat':'no-repeat'
		});
	},
	onComplete: function(t1,t2) {
		$(inputName).setStyle('background','');
	}
	});
}

function autoCompleteDropdownCustomer(inputName, tblName, fldName, urlJSON, length, statevalue)
{
	var force = true;
	if(length === undefined) { length = 3; }
	if (statevalue !== undefined) 
	{ 
		force = false; 
	}
	new Autocompleter.Request.JSON(inputName, urlJSON + '/' + tblName + '/' + fldName + '/' +  inputName + '/' + statevalue, {
		'postVar': inputName,
		minLength: length,
		maxChoices: 50,
		autoSubmit: false,
		cache: true,
		forceSelect: force,
		delay: 0,
		filterCase : true,
		onRequest: function() {
			$(inputName).setStyles({
			'background-image':'url('+ CONFIG.baseurl +'/includes/indicator_blue_small.gif)',
			'background-position':'center right',
			'background-repeat':'no-repeat'
			});
		},
		onComplete: function(t1,t2) {
			$(inputName).setStyle('background','');
		},
		onSelection: function(el, sel, val, input){
	
			var customerState = $('state').get('value');
			var suburbPostcode = $('suburb').get('value').split(' - ');

			$('suburb').set('value', suburbPostcode[0]);
			$('postcode').set('value', suburbPostcode[1]);
			/*
			if(customerState && customerSuburb){
				new Request.JSON({
					url: URLS.autoCustomerPostcode + '/' + customerState + '/' + customerSuburb,
					onSuccess: function(postcode)
					{
						$('postcode').set('value', postcode);
					}
				}).send();
			};*/
		}
	});
}

function autoCompleteDropdownAdsource(inputName, tblName, fldName, urlJSON, length, max)
{
	if(length === undefined) { length = 3; }
	if(max === undefined) { max = 50; }
	new Autocompleter.Request.JSON(inputName, urlJSON + '/' + tblName + '/' + fldName + '/' +  inputName, {
	'postVar': inputName,
	minLength: length,
	maxChoices: max,
	autoSubmit: false,
	cache: true,
	forceSelect: true,
	delay: 0,
	filterCase : true,
	onRequest: function() {
		$(inputName).setStyles({
		'background-image':'url('+ CONFIG.baseurl +'/includes/indicator_blue_small.gif)',
		'background-position':'center right',
		'background-repeat':'no-repeat'
		});
	},
	onComplete: function(t1,t2) {
		$(inputName).setStyle('background','');
	},
	onSelection: function(){
		
		//$$('.error').dispose();
		// on select, check if the value of adsource is "word of mouth"
		var adsValue = $('adsource').get('value');
		
		if(adsValue == 'Word of Mouth' || adsValue == 'Word of Mouth Domestic'){
			
			
			
			console.log(adsValue);
			// if yes, display the option if from Personnel or from other
			$('subadsource').show().addClass('required');
			$('subadspersonnel').hide();
			$('subadsother').hide();

			// bind an event to the sub-adsource option
			$('subadsource').addEvent('change', function(){

				// if they select "personnel", display the list of personnels
				if(this.get('value') === 'personnel'){
					$('subadspersonnel').show().set('name', 'subadsource').addClass('required');
					$('subadsother').hide().set('name', '').removeClass('required');

					// destroy the error on sub-adsource select box
					if($('subadsource').getNext('div')){
						$('subadsource').getNext('div').destroy();
					}

					//if the select others, display an input box
				} else if(this.get('value') === 'other'){
					$('subadspersonnel').hide().set('name', '').removeClass('required');
					$('subadsother').show().set('name', 'subadsource').addClass('required');

					// destroy the error on sub-adsource select box
					if($('subadsource').getNext('div')){
						$('subadsource').getNext('div').destroy();
					}

					// if they didnt select any
				} else {
					$('subadspersonnel').hide().set({'value': '', 'name': ''}).removeClass('required');
					$('subadsother').hide().set({'value': '', 'name': ''}).removeClass('required');
				}
			})

			// hide the inputs for sub-adsource if didn't select "word of mouth"
		} else {
			$('subadsource').hide().set({'value': '', 'name': ''}).removeClass('required');
			$('subadspersonnel').hide().set({'value': '', 'name': 'subadsource'}).removeClass('required');
			$('subadsother').hide().set({'value': '', 'name': ''}).removeClass('required');
		}


	}
	});
}

var filetree;
function getVersions(file)
{
	new Request.JSON({
		method: 'GET',
		url: 'getVersions.json?file=' + file,
		onComplete: function(response)
		{
			updateData(response);
		}
	}).send();
}

function updateData(data)
{
	var container = $('data_container');
	container.set('html', '');
	var file = data.file;
	var revisions = data.data;

	var title = new Element('div',
	{
	'class': 'data_file'
	}).set('html', file).injectInside(container);

	if (revisions)
	{
		// add events to actually download specified file & revision
		revisions.each(function(revision)
		{
			var div = new Element('div',
			{
			'class': 'data_rev'
			}).set('html', 'Revision: ' + revision.revision + '<br/>Modified: ' + revision.date).injectAfter(title);
			div.addEvent('click', function()
			{
				location.href = 'admin_filesystem_download.do?file=' + file + '&rev=' + revision.revision;
			});
		});
	}
}

function loadTree()
{
	var demo_path = CONFIG.baseurl;
	Mif.Tree.Node.implement(
	{

		getPath: function()
		{
			var path = [];
			var node = this;
			while(node)
			{
				path.push(node.name);
				node = node.getParent();
			}

			return path.reverse().join('/');
		}

	});


	filetree = new Mif.Tree(
	{
		container: $('tree_container'),

		initialize: function()
		{
			this.initSortable();
			new Mif.Tree.KeyNav(this);
			this.addEvent('nodeCreate', function(node)
			{
				node.set(
				{
					property:
					{
						id:	node.getPath()
					}
				});
			});

			var storage = new Mif.Tree.CookieStorage(this);

			this.addEvent('load', function()
			{
				storage.restore();
			}).addEvent('loadChildren', function(parent)
			{
				storage.restore();
			});
		},

		types: {
			folder:
			{
				openIcon: 'mif-tree-open-icon',
				closeIcon: 'mif-tree-close-icon',
				loadable: true
			},
			file:
			{
				openIcon: 'mif-tree-file-open-icon',
				closeIcon: 'mif-tree-file-close-icon'
			},
			loader:
			{
				openIcon: 'mif-tree-loader-open-icon',
				closeIcon: 'mif-tree-loader-close-icon',
				DDnotAllowed: ['inside','after']
			}
		},
		dfltType: 'folder',
		onClick: function(node)
		{
			getVersions(node.getPath());
		}
	});

	filetree.load({
		url: demo_path + 'getRoot.json'
	});

	filetree.loadOptions = function(node)
	{
		return {
			url: demo_path + 'getPath.json',
			data: {'abs_path': node.data.abs_path}
		};
	};

	document.addEvent('keydown', function(event){
		if(event.key != 'r') return;
		var node = filetree.selected;
		if(!node) return;
		node.rename();
	});

}

function setDefaultWidgets(personneltypes_id, forms_id)
{
	new Request.JSON({
		method: 'GET',
		url: 'getDefaultWidgets.json/' + personneltypes_id,
		onComplete: function(response)
		{
			$$('#' + forms_id + ' input[type=checkbox]').each(function(check)
			{
				check.removeAttribute('checked');
			});
			
			response.each(function(res)
			{
				if (res.status == 1)
				{
					$$('#' + forms_id + ' #widget-' + res.widgets_id).set('checked', 'checked');
				}
			});
		}
	}).send();
	
}