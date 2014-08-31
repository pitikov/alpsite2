/* @file Файл JS скриптов сайта федерации - Управление членами федерации.
 * 
 * @author E.A.Pitikov <pitikov@yandex.ru> */


function showFederationProfile(id) {
    $.ajax({
        url:'/index.php/federation/editmember',
        data:{'id':id},
        type:'GET',
        beforeSend: function(xhr) {
            $('.memberName').html('');
            $('#memberPhoto').prop('src', '/images/noavatar.png');
            $('#memberDob').html('');
            $('#memberFrom').html('');
            $('#memberTo').html('');
            $('#memberDescription').html('');
            $('#memberRole').html('');
        },
        success: function(data, textStatus, jqXHR) {
            $('.memberName').html(data.name);
            $('#memberPhoto').prop('src', data.photo);
            $('#memberDob').html(data.dob===null?'не известно':data.dob);
            $('#memberFrom').html(data.from===null?'не известно':data.from);
            $('#memberTo').html(data.to===null?'по настоящее время':data.to);
            $('#memberDescription').html(data.description);

            $.ajax({
                url:'/index.php/federation/getrole',
                dataType: 'json',
                data:{'id':data.role},
                type: 'GET',
                success: function(role, textStatus, jqXHR) {
                    $('#memberRole').html(role.title);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#memberRole').html('член федерации');
                }
            });
            $('#MemberProfile').dialog('open');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Что - пошло не так. Запрос данных ччлена федерации вернул '+status+" "+errorThrow);
        },
        dataType: 'json',
    }); 
};

function newFederationMember() {
    $('#MemberFormCaptionHeader').html('Новая учетная запись');
    memberFormPrepare();
    $('#memberId').val(0);
    $('#memberName').val('');
    $('#memberDob').val('');
    $('#memberPhoto').prop('src', '/images/noavatar.png');
    $('.redactor_').html('');
    $('#memberFrom').val('');
    $('#memberTo').val('');
    $('#FederationMemberDialog').dialog('open');
};

function memberFormPrepare()
{
    var status = $('#action_status');
    status.removeClass('flash-error');
    status.removeClass('flash-success');
    status.html('');
    
    $.ajax({
        url:'/index.php/federation/roles',
	dataType:'json',
	success:function(data){
	  var roles = $('#memberRole');
	  roles.html('');
	  $.each(data, function(i, item){
	      roles.append("<option class='role' value="+i+">"+item+"</option>");
	  });
 	  $('#memberRole').val(null);
	},
	error:function(xhtml, status, errorThrow) {
	    alert('Что - пошло не так. Запрос должностей федераци вернул '+status);
	}
    });
    $.ajax({
	url:'/index.php/federation/users',
	dataType:'json',
	success:function(data){
	  var users = $('#memberUid');
	  users.html('');
	  $.each(data, function(i, item){
	      users.append("<option value="+i+">"+item+"</option>");
	  });
 	  $('#memberUid').val(null);
	},
	error:function(xhtml, status, errorThrow) {
	    alert('Что - пошло не так. Запрос списка пользователей сайта вернул '+status+" "+errorThrow);
	}
    });
};

function saveFederationMember()
{
    if($('#memberId').val()==='') {
        $('#memberId').val('undeined');
    }
    $.ajax({
	url:'/index.php/federation/addmember',
        dataType: 'json',
        type: 'POST',
        data: {
            'id':$('#memberId').val(),
            'name':$('#memberName').val(),
            'dob':$('#memberDob').val(),
            'photo':$('#memberPhoto').attr('src'),
            'description':$('.redactor_').html(),
            'from':$('#memberFrom').val(),
            'to':$('#memberTo').val(),
            'role':$('#memberRole').val(),
            'uid':$('#memberUid').val()
            },
        success: function (data, textStatus, jqXHR) {
            var status = $('#action_status');
            status.addClass('flash-success');
            status.html('Данные сохраненны');
            cancelFederationMember();
            $('#FederationMembers').yiiGridView('update');
                    },
        error: function (jqXHR, textStatus, errorThrown) {
            var status = $('#action_status');
            status.addClass('flash-error');
            status.html(errorThrown);
                    }
    });
};

function cancelFederationMember()
{
    $("#FederationMemberDialog").dialog('close');
};

function uploadPhoto()
{
    alert('This function not implicted');
};

function editFederationMember(id) 
{   
    $.ajax({
        url:'/index.php/federation/editmember',
        dataType: 'json',
        type:'GET',
        data:{'id':id},
        success:function(data, textStatus, jqXHR){
            memberFormPrepare();
            $('#MemberFormCaptionHeader').html('Редактирование учетной записи члена федерации');
            
            $('#memberName').val(data.name);
            $('#memberDob').val(data.dob);
            $('.redactor_').html(data.description);
            $('#memberFrom').val(data.from);
            $('#memberTo').val(data.to);
            $('#memberRole').val(3);
            $('#memberUid').val(1);
            $('#memberId').val(data.id);
            $("#FederationMemberDialog").dialog('open');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Что - пошло не так. Запрос данных члена федерации вернул '+status+" "+errorThrow);
        }
    });
};