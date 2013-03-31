function insertReadmore(editor) {
	var content = tinyMCE.get(editor).getContent();
	if (content.match(/<hr\s+id=("|')system-readmore("|')\s*\/*>/i)) {
		alert('error al insertar readmore');
		return false;
	} else {
		jInsertEditorText('<hr id="system-readmore" />', editor);
	}
}	

var jublog = {
	$: function(id) {
		return document.getElementById(id);
	},
	defined: function(value) {
		return typeof(value) != "undefined";
	},
	css: function(id, param, value) {
		if (this.defined(value)) this.$(id).style[param] = value;
		else return this.$(id).style[param];
	},
	val: function(id, v) {
		if (this.defined(v)) this.$(id).value = v;
		else return this.$(id).value;
	},
	html: function(id, value) {
		if (this.defined(value)) this.$(id).innerHTML = value;
		else return this.$(id).innerHTML;
	},
	show: function(id,s) {
		if (this.defined(s)) s = s ? "" : "none";
		else s = this.css(id,"display") == "none" ? "" : "none";
		this.css(id,"display",s);
	},
	visible: function(id,s) {
		if (this.defined(s)) s = s ? "" : "hidden";
		else s = this.css(id,"visibility") == "hidden" ? "" : "hidden";
		this.css(id,"visibility",s);
	}
};

jublog.article = {
	enviar: function() {
		jublog.editorSave();
		if (jublog.val('title') && (jublog.val('catid') || jublog.val('new_cat'))) {
			jublog.$('jublogForm').submit();
		}
		else {
			alert(jublog.msgs.FILL_REQUIRED_FIELDS);
		}
	},
	change_category: function(value) {
		jublog.show('new_cat_div', value==0);
	},
	check_category: function() {
		this.change_category(jublog.val('catid'));
	}
};

jublog.personal = {
	enviar: function() {
		jublog.editorSave();
		jublog.$('jublogForm').submit();
	}
};
