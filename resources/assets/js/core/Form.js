import Errors from './Errors';
import { apiUrl, getHeader } from './../config';

class Form {
	
	constructor(data){
		this.originalData = data;

		for(let field in data) {
			this[field] = data[field];
		}

		this.errors = new Errors();
	}

	data(){
		
		let data = {};

		for (let property in this.originalData){
			data[property] = this[property];
		}

		return data;

	}

	reset(){
		
		for(let field in this.originalData) {
			this[field] = '';
		}

		this.errors.clear();

	}

	//post request
	post(url){
		return this.submit('post', url);
	}

	//get request
	get(url){
		return this.submit('get', url);
	}

	//delete request
	delete(url){
		return this.submit('delete', url);
	}

	//update request
	update(url){
		return this.submit('patch', url);
	}

	submit(requestType, url){
		
		return new Promise((resolve, reject) => {

			axios[requestType](url, this.data(), { headers: getHeader() })
			.then(response => {
				this.onSuccess(response);

				resolve(response);
			})

			.catch(error => {
				this.onFail(error.response);

				reject(error.response);
			});

		});

	}

	onSuccess(data){
		//alert(data.message);
		
		this.reset();
	}

	onFail(errors){
		this.errors.record(errors);
	}

}

export default Form;