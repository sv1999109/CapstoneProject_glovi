import React from 'react';
import Header from '../../Components/Header/Header'
import Footer from '../../Components/Footer/Footer'
import VanImg from '../../assets/Parcel.png'
import './ServicesStyle.css'

function Parcel() {
    return (
        <>
            <Header />
            <div className="Servicebody">
                <div className='Servicerow'>
                    <div className='Serviceimg'>
                        <img src={VanImg} alt='Van_Image' />
                    </div>

                    <div className='Servicecontentwrapper'>
                        <div className='Servicecontent'>
                            <h2>Parcel Delivery</h2>
                            <p>Sending individual items is a breeze with our Parcels Shipping Service. Perfect for personal and business shipments,
                                we offer reliable and versatile solutions for parcels weighing up to 30 kg. Whether it's clothing, electronics,
                                books, or any personal item, our service ensures your parcels reach their destination safely and in top condition.</p>

                            <h3>Service Highlights:</h3>
                            <ul>
                                <li><b>Maximum Weight:</b> Up to 30 kg</li>
                                <li><b>Examples of Items:</b> Clothing,Electronics,Books</li>
                            </ul>

                            <p>Experience the convenience of seamless tracking and timely deliveries, making our Parcels Shipping Service your go-
                                to solution for shipping individual items worldwide.</p>
                        </div>
                    </div>

                </div>
            </div>

            <Footer />

        </>
    );
}

export default Parcel;
