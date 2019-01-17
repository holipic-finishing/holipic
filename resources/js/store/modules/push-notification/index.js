import router from '../../../router';
import config from '../../../config/index.js'
import  { post, get } from '../../../api/index.js'


const state = {
    user: localStorage.getItem('user'),
}

// getters
const getters = {
    getAuthUser: state => {
        return state.user;
    }
}

// actions
const actions = {
    connectionPushNotification(context, payload) {
   
        const { user } = payload;	
        
	    var data = {
	     	company_id: payload.user.company_id,
	     	user_id : payload.user.id,
	     	email: payload.user.email
	     }

       //  var OneSignal = window.OneSignal || [];
	      // OneSignal.push(["init", {
	      //     appId: "d4cb0199-4846-481d-9388-39ba00fe2773",
	      //     subdomainName: 'wbtotalter',
	      //     autoRegister: false,
	      //     safari_web_id: 'web.onesignal.auto.50d89199-747f-4818-96ca-50d4208129fc',
	      //     httpPermissionRequest: {
	      //      enable: true
	      //     },
	      //     notifyButton: {
	      //         enable: true
	      //     },
	      //     welcomeNotification: {
	      //         disable: true
	      //     },
	      //     promptOptions: {
	      //         siteName: "Laravel Webpush Notification",
	      //         actionMessage: "Can you use it when you can believe it or not?",
	      //         acceptButtonText: "ALLOW",
	      //         cancelButtonText: "NO, THANK",
	      //     }
	      // }]);
	      OneSignal.push(function() {

	        // OneSignal.showHttpPrompt();
	       
	          	// OneSignal.on('subscriptionChange', function (isSubscribed) {
	              	// console.log("The user's subscription state is now:", isSubscribed);
		        	OneSignal.sendTag("user_id",JSON.stringify(data),function(tagsSent)
                    {	
                      	context.commit('connectiononesignal');	
                    });
	         //   		OneSignal.push(function() {
        		// 		OneSignal.getUserId(function(userId) {
	      			// 		localStorage.setItem('id_one_signal',userId)
        		// 		});
      				// });
	      			
	      		});
	      // });     
	      // context.commit('connectiononesignal');	
    },
}

// mutations
const mutations = {
    connectiononesignal(state) {
     	 OneSignal.push(function() {
			 OneSignal.getTags(function(tags) {
			 	var data = JSON.parse(tags.user_id)	
	      		var url = config.API_URL + 'update-onesignal-id'
	      		let params = {
	      			email : data.email,
	      			id_one_signal: localStorage.getItem('id_one_signal')
	      		}
	      		post(url,params)
	      		.then(res => {
	      			
	      		})
	      		.catch(err => {
	      			console.log(err)	
	      		})
        	});
      	});
    },
}    

export default {
   state,
   getters,
   actions,
   mutations
}