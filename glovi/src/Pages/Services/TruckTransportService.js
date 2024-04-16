import React from 'react';
import Header from '../../Components/Header/Header'
import Footer from '../../Components/Footer/Footer'
import TruckImg from '../../assets/Truck.png'
import './ServicesStyle.css'

function Truck() {
    return (
        <>
            <Header />
            <div className="Servicebody">
                <div className='Servicerow'>
                    <div className='Serviceimg'>
                        <img src={TruckImg} alt= "truck-transportation" />
                    </div>

                    <div className='Servicecontentwrapper'>
                        <div className='Servicecontent'>
                            <h2>Truck Transport Service</h2>
                            <p>When it comes to larger loads, our Truck Transport Service has you covered. With variable weight
                                 capacities based on truck size, we ensure the safe and efficient delivery of bulk goods or 
                                 construction materials. Trust us for reliable transportation for your heavier shipments,
                                  where security and timeliness are our top priorities.</p>

                            <h3>Service Highlights:</h3>
                            <ul>
                                <li><b>Maximum Weight:</b> Varies by truck capacity</li>
                                <li><b>Examples of Items:</b> Bulk goods, Construction materials</li>                               
                            </ul>

                            <p>Experience the ease of shipping larger loads with our dedicated Truck Transport Service, providing
                                 tailored solutions for your specific shipping needs.</p>
                        </div>
                    </div>

                </div>
            </div>

            <Footer />

        </>
    );
}

export default Truck;
