import axios from 'axios';
import { getHeader } from './../config';

export const HTTP = axios.create({
	
    headers: getHeader()

})