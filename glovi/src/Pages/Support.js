import React from 'react';
import Header from '../Components/Header'
import Footer from '../Components/Footer'
import { FaArrowRight } from 'react-icons/fa';
import SupportImg from '../assets/SupportImg.jpg'
import './SupportStyle.css'


function Support() {
    return (
        <>
            <Header />
            <div id='Supportbody'>
                <div className='SupportContainer'>
                    <form className='SupportLeft'>
                        <div className='SupportLeftTite'>
                            <h2>Get in touch</h2>
                            <hr />
                        </div>
                        <input type='text' name='name' placeholder="Your Name" className='SupportInputs' required />
                        <input type='email' name='email' placeholder="Your E-mail" className='SupportInputs' required />
                        <input type='text' name='subject' placeholder="Subject" className='SupportInputs' required />
                        <textarea name='message' placeholder='Your Message' className='SupportInputs' required />
                        <button type='submit'>Submit <FaArrowRight /></button>
                    </form>
                    <div className='SupportRight'>
                        <img src={SupportImg} alt='' />
                    </div>

                </div>
            </div>
            <Footer />
        </>
    );
}

export default Support