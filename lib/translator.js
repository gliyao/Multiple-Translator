/*
 * @author : Liyao
 * last update:2011.1.8
 */
var MT = MT || {};
MT.NAME = "Multiple Translator";
MT.VERSION = 0.1;

//MultipleTranslator
MT.Start = function(){
	MT.translating=false;
	MT.is_dirty=false;
	MT.delay=800;
	MT.source = new MT.Source('sourceText');
	MT.setting = new MT.Setting('langFrom','langTo');
	MT.trslateBtn = document.getElementById('Tanslate').onclick=this.translate;
	document.getElementById('sourceText').onkeyup = MT.keyUpTranslate;
	MT.translators=[];
	//add translators	
	MT.addTranslator(new MT.TGoogle("Google"));
	MT.addTranslator(new MT.TBing("Bing"));
};

/**
 * add translator to MT.translators
 * @param {Object} t
 */
MT.addTranslator=function(t){
	t.setSource(this.source);
    t.setSetting(this.setting);
    MT.translators.push(t);
    t.setIndex(MT.translators.indexOf(t));
};

MT.translate = function(){
	//console.log('MT.translate');
    if (!MT.translating) {
        MT.translating = true;
        MT.source.refreshText();//refresh source text
        MT.translators.forEach(function(element, index, array){
			element.translate();
        });
    }
    MT.translating = false;
    if (MT.is_dirty) {
        MT.is_dirty = false;
    }
};
/**
 * for Instant Translation
 */
MT.keyUpTranslate = function(){
    if (!MT.is_dirty) {// add small delay here to create "intent"
        setTimeout(function(){
            MT.translate();
        }, MT.delay);
    }
    MT.is_dirty = true;
};
//end of class MultipleTranslator


//Static calss Utility
MT.Utility = function(){}
MT.Utility.head = window.document.getElementsByTagName("head")[0];

//class Source
/**
 * input textarea's id
 * this class have two public variable 
 * 1. source: HTML Object<Textarea> 
 * 2. text: encode from source value.
 * @param {Object} TextArea
 */
MT.Source=function(textarea){
	//getter
	this.getText=function(){return text;}
	
	//
    this.refreshText = function(){
        text = encodeURIComponent(eTextArea.value);//經過編碼中->英才不會變亂碼
    };
	this.update = function(){
        text = encodeURIComponent(eTextArea.value);//經過編碼中->英才不會變亂碼
    };
	
	//private var
	var eTextArea=document.getElementById(textarea);;
	var text;
}
//end of Source

//class Setting
/**
 * Control languages settings, switch language code
 * @param {Object} langFrom
 * @param {Object} langTo
 */
MT.Setting=function(langFrom, langTo){
	//Constructor
	//private var
	var langFrom=document.getElementById(langFrom);
	var langTo=document.getElementById(langTo);
	
	//add Language selections
    for (var langName in Languages) {
        var code = Languages[langName];
        appendOption(langName, code, langFrom);
        appendOption(langName, code, langTo);
    }
	
	//Default lang setting
    langFrom.value = Languages["CHINESE_TRADITIONAL"];
    langTo.value = Languages["ENGLISH"];
	
	//private appendOption
	function appendOption(text,value ,targetNode){
		var NewOp = document.createElement('OPTION');
        NewOp.text = text;
        NewOp.value = value;
        targetNode.add(NewOp,null);
	};
	
	//public getter
	this.getLangFrom=function(){return langFrom.value;};
	this.getLangTo=function(){return langTo.value;};
	this.setLangFrom=function(v){langFrom.value=v};
	this.setLangTo=function(v){langTo.value=v};
	
	
	//逼不得已使用絕對位置
    this.switchLang = function(e){
//		console.log('switchLang');
		var s=MT.setting;
        var temp = s.getLangFrom();
        s.setLangFrom(s.getLangTo());
		s.setLangTo(temp);
		MT.translate();
    };
	//set switch button event
	document.getElementById('LangSwitch').onclick=this.switchLang;
}
//end of class Setting


//class Translator
//public Translator(string appId)
MT.Translator = function(appId,dist){
	//private 
	var appId = appId;
	var index;
	var source;
	var setting;
	var eDist=document.getElementById(dist);
	this.d=document.getElementById(dist);
	
	//public setter and getter
    this.getAppId = function(){return appId};
	this.setSource=function(s){source=s};
	this.setSetting=function(t){setting=t};
	this.setIndex=function(i){index=i};
	this.getIndex=function(){return index};
	this.getLangFrom=function(){return setting.getLangFrom()};
	this.getLangTo=function(){return setting.getLangTo()};
	this.getText=function(){return source.getText()};
	this.getDist=function(){return eDist};
	
	//public translate
    this.translate = function(){
		//console.log(this.getUrl());
        if (this.getUrl != "") {
            var newScript = document.createElement('script');
            newScript.src = this.getUrl();
            MT.Utility.head.appendChild(newScript);
			//console.log(this.getUrl());
        } else {
            throw new Error("url is null!");
        }
    };
	
    this.writeResponse = function(translated){eDist.innerHTML = translated};
	
	this.setResponse=function(response){this.writeResponse(response)};
}
//end of class Translator

//class TGoogle : Translator
//public TGoogle
MT.TGoogle = function(dist){
    MT.Translator.call(this, "AIzaSyAPuiCrkNL3KJHK9ckUwxZst-NAna9uPNc",dist);
    
	this.getUrl = function(){
        return 'https://www.googleapis.com/language/translate/v2?key=' + this.getAppId() + '&source=' + this.getLangFrom() + '&target=' + this.getLangTo() + '&callback=MT.translators['+this.getIndex()+'].setResponse&q=' + this.getText();
    };
	
	//rewrite setResponse because google have different response structure. 
    this.setResponse = function(response){
        this.writeResponse(response.data.translations[0].translatedText);
    };
}
MT.TGoogle.prototype = new MT.Translator();
MT.TGoogle.prototype.constructor = MT.TGoogle;
//end of class TGoogle


//class TBing : Translator
//public TBing
MT.TBing = function(dist){
    MT.Translator.call(this, "0142F39F370E1FFCBA57843843E9940DC271CAAB",dist);
	
    this.getUrl = function(){
        return "http://api.microsofttranslator.com/V2/Ajax.svc/Translate?oncomplete=MT.translators["+this.getIndex()+"].setResponse&appId=" + this.getAppId() + "&from=" + this.getLangFrom() + "&to=" + this.getLangTo() + "&text=" + this.getText();
    };
}
MT.TBing.prototype = new MT.Translator();
MT.TBing.prototype.constructor = MT.TBing;
//end of class TBing


MT.Start();

