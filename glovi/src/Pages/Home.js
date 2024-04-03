import React, { useState, useEffect } from 'react';
import Header from '../Components/Header';
import Footer from '../Components/Footer';
import DHLExpress from '../assets/DHLExpress.png';
import Fedex from '../assets/Fedex.svg';
import Ups from '../assets/Ups.jpg';
import Dhl from '../assets/Dhl.jpg';
import Sendle from '../assets/Sendle.jpg';
import AustraliaPost from '../assets/AustraliaPost.svg';
import DeliveryPartner from '../assets/OurDeliveryPartner.jpg';
import './HomeStyle.css';

export default function Home() {
    // const images = [DeliveryPartner,DHLExpress, Fedex, Ups, Dhl, Sendle, AustraliaPost];
    // const [currentSlide, setCurrentSlide] = useState(0);

    // useEffect(() => {
    //     const interval = setInterval(() => {
    //         setCurrentSlide((prevSlide) => (prevSlide + 1) % images.length);
    //     }, 3000); // Change slide every 3 seconds

    //     return () => clearInterval(interval);
    // }, [images.length]);

    // const handleDotClick = (index) => {
    //     setCurrentSlide(index);
    // };

    return (
        <>
            <Header />
            {/* {/* <div id='Sliderbody'>
                <div className='SliderContainer'>
                    <div className='slide-row' style={{ transform: `translateX(-${currentSlide * 100}%)` }}>
                        {images.map((image, index) => (
                            <div key={index} className='slide'>
                                <img src={image} alt={`Slide ${index}`} />
                            </div>
                        ))}
                    </div>
                    <section className='dots'>
                        {images.map((_, index) => (
                            <div
                                key={index}
                                className={index === currentSlide ? 'dot active' : 'dot'}
                                onClick={() => handleDotClick(index)}
                            ></div>
                        ))}
                    </section>
                </div>
            </div> */}
            {/* <div id="hero-section" class="hero-section">
                <div class="hero-wrapper call-to-action-below h-100">
                    <div class="hero-vector"><img src="{{ asset('assets/img/hero-vector.svg') }}" alt="hero vector"/>
                    </div>
                    <div class="container">
                        <div class="row mt-4 mb-5  hero-center">
                            <div class="col-lg-12 call-to-action-invite">
                                <h1 class="typed-result text-bold text-capitalize" style={{height: '100px'}}></h1>
                                {/* <h1 class="text-bold text-capitalize typed-text" style="display: none">
                                    {{ get_content_locale(get_contents('home_hero_title')) }},, {!!nl2br(get_content_locale(get_contents('home_hero_desc')))!!}</h1> */}

                            {/* </div>
                            <div class="col-lg-12 call-to-action-button mt-5">
                                <form action="{{ route('tracking') }}">
                                    <div class="card border-primary justify-content-center text-center tracking-section">

                                        <div class="card-body px-lg-4 ">

                                            <div class="form-group mb-3">
                                                <input style={{borderRadius: '8px', fontSize: '12px'}} type="text" name="code"
                                                    class="form-control form-control-lg text-center box-shadow"
                                                    placeholder="@lang('messages.Tracking_Number_Input')" required/>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-blue btn-block w-100"><span class="me-3">@lang('messages.Track')
                                        </span><i class="fa fa-chevron-circle-right"></i></button>
                                    </div>
                                </form>

                            </div>

                        </div>
                        <div class="row styles-pills mt-4 hero-center">

                            <div class="hero-below-div mb-2 col-md-4">
                                <div class="hero-span"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check"
                                    class="svg-inline--fa fa-check hero-span-svg" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path fill="currentColor"
                                        d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z">
                                    </path>
                                </svg>Easy ordering</div>
                            </div>
                            <div class="hero-below-div mb-2 col-md-4">
                                <div class="hero-span"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check"
                                    class="svg-inline--fa fa-check hero-span-svg" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path fill="currentColor"
                                        d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z">
                                    </path>
                                </svg>Multiple carriers</div>
                            </div>
                            <div class="hero-below-div mb-2 col-md-4">
                                <div class="hero-span"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check"
                                    class="svg-inline--fa fa-check hero-span-svg" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path fill="currentColor"
                                        d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z">
                                    </path>
                                </svg>Secure payment</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div> *} */}

            <div style={{height:"300px", marginTop:"110px"}}>
                <h1>Home Page under construction.Please be patient!!!</h1>
            </div>

            <Footer />
        </>
    );
}
