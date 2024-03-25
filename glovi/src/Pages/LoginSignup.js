import React, { useState } from 'react';
import './LoginSignupStyles.css';
import PhoneInput from 'react-phone-number-input';
import 'react-phone-number-input/style.css'

function Login() {

    const [value, setvalue] = useState();


    return (
        <div className="container">
            <div className='Main'>
                <input type='checkbox' id='chk' aria-hidden="true" />

                <div className='Signup'>
                    <form>
                        <label htmlFor="chk" aria-hidden="true" className='SignupAndLoginLabel'>Sign Up</label>
                        <input className='LoginSignupInput' type='text' name='txt' placeholder='Username' required="" />
                        <input className='LoginSignupInput' type='text' name='FirstLastName' placeholder='First and Last Name' required="" />
                        <input className='LoginSignupInput' type='email' name='email' placeholder='Email' required="" />
                        <PhoneInput className='PhoneInputContainer'
                            value={value}
                            onChange={value => setvalue(value)}
                            defaultCountry="CA"
                            placeholder=' Mobile Number'
                            required=""
                        />

                        <input className='LoginSignupInput' type='password' name='password' placeholder='Select Country' required="" />
                        <input className='LoginSignupInput' type='password' name='password' placeholder='Password' required="" />
                        <input className='LoginSignupInput' type='password' name='password' placeholder='Confirm Password' required="" />
                        <button className='btnLoginSignup'>Sign up</button>
                    </form>
                </div>

                <div className='Login'>
                    <form>
                        <label htmlFor="chk" aria-hidden="true" className='SignupAndLoginLabel'>Login</label>
                        <input className='LoginSignupInput' type='text' name='txt' placeholder='Username' required="" />
                        <input className='LoginSignupInput' type='password' name='password' placeholder='Password' required="" />
                        <button className='btnLoginSignup'>Login</button>
                    </form>
                </div>

            </div>
        </div>
    );
}

export default Login;