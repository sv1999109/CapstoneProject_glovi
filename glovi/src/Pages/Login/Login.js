import React, { useState } from 'react';
import './LoginStyles.css';
import { useNavigate } from 'react-router-dom';
import 'react-phone-number-input/style.css'
import { Link } from 'react-router-dom';

function Login() {
    const navigate = useNavigate();
    const [isSignUpMode, setIsSignUpMode] = useState(false);
    const [isLinkClicked, setIsLinkClicked] = useState(true);
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const [showPassword, setShowPassword] = useState(false);

    const handleLinkClick = () => {
        setIsLinkClicked(false);
    };

    const handleSignUpClick = () => {
        setIsSignUpMode(true);
    };

    const handleSignInClick = () => {
        setIsSignUpMode(false);
    };

    const handleLogin = (e) => {
        e.preventDefault();
        if (username === 'Admin' && password === 'Group5') {
            navigate('/Dashboard');
        } else {
            setError('The Username or Password is incorrect.');
        }
    };

    return (
        <>
            <div className={`Logincontainer ${isSignUpMode ? 'sign-up-mode' : ''}  ${isLinkClicked ? 'container-open' : 'container-close'}`}>


                <div className='SignupLoginBody'>
                    <div className="forms-container">
                        <div className="signin-signup">
                            <form action="#" className={`sign-in-form ${isSignUpMode ? 'hidden' : ''}`} onSubmit={handleLogin}>
                                <h2 className="title">Sign in</h2>
                                <div className="input-field">
                                    <i className="fas fa-user"></i>
                                    <input type="text" placeholder="Username" value={username} onChange={(e) => setUsername(e.target.value)} />
                                </div>
                                <div className="input-field">
                                    <i className="fas fa-lock"></i>
                                    <input type={showPassword ? "text" : "password"} placeholder="Password" value={password} onChange={(e) => setPassword(e.target.value)} />
                                    <i className={`fas ${showPassword ? "fa-eye-slash" : "fa-eye"} password-toggle-icon`} onClick={() => setShowPassword(!showPassword)}></i> {/* Eye icon to toggle password visibility */}
                                </div>
                                <input type="submit" value="Login" className="btn solid" />
                                {error && <p className="error">{error}</p>}
                                <p className="social-text">Or Sign in with social platforms</p>
                                <div className="social-media">
                                    <a href="#" className="social-icon">
                                        <i className="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" className="social-icon">
                                        <i className="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" className="social-icon">
                                        <i className="fab fa-google"></i>
                                    </a>
                                    <a href="#" className="social-icon">
                                        <i className="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                            </form>
                            <form action="#" className={`sign-up-form ${isSignUpMode ? '' : 'hidden'}`}>
                                <h2 className="title">Sign up</h2>
                                <div className="input-field">
                                    <i className="fas fa-user"></i>
                                    <input type="text" placeholder="Username" />
                                </div>
                                <div className="input-field">
                                    <i className="fas fa-envelope"></i>
                                    <input type="email" placeholder="Email" />
                                </div>
                                <div className="input-field">
                                    <i className="fas fa-lock"></i>
                                    <input type={showPassword ? "text" : "password"} placeholder="Password" value={password} onChange={(e) => setPassword(e.target.value)} />
                                    <i className={`fas ${showPassword ? "fa-eye-slash" : "fa-eye"} password-toggle-icon`} onClick={() => setShowPassword(!showPassword)}></i> {/* Eye icon to toggle password visibility */}
                                </div>
                                <input type="submit" className="btn" value="Sign up" />
                                <p className="social-text">Or Sign up with social platforms</p>
                                <div className="social-media">
                                    <a href="#" className="social-icon">
                                        <i className="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" className="social-icon">
                                        <i className="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" className="social-icon">
                                        <i className="fab fa-google"></i>
                                    </a>
                                    <a href="#" className="social-icon">
                                        <i className="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div className="panels-container">
                        <Link to="/" className="close" onClick={handleLinkClick}></Link>
                        <div className="panel left-panel">
                            <div className="content">
                                <h3>Don’t have an account yet?</h3>
                                <p></p>
                                <button className="btn transparent" id="sign-up-btn" onClick={handleSignUpClick}>
                                    Sign up
                                </button>
                            </div>
                            <img src="img/log.svg" className="image" alt="" />
                        </div>
                        <div className="panel right-panel">
                            <Link to="/" className="close" onClick={handleLinkClick}></Link>
                            <div className="content">
                                <h3>Already have an account?</h3>
                                <p></p>
                                <button className="btn transparent" id="sign-in-btn" onClick={handleSignInClick} >
                                    Sign in
                                </button>
                            </div>
                            <img src="img/register.svg" className="image" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default Login;