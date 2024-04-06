import React from "react";
import Header from '../../Components/Header/Header'
import Footer from '../../Components/Footer/Footer'
import './BlogsStyle.css'
import PalletStacking from '../../assets/PalletStacking.jpg'
import MasterArt from '../../assets/MasterArt.jpg'
import Prohibited from '../../assets/Prohibited.jpg'

function Blogs() {
    return (
        <>
            <Header />
            <div id="Blogsbody">
                <section id="blogsection">
                    <div className="blogheading">
                        <span>My Recent Posts</span>
                        <h3>My Blogs</h3>
                    </div>

                    <div className="blogcontainer">
                        {/* Blogbox1 */}
                        <div className="blogbox">
                            <div className="blogImg">
                                <img src={PalletStacking} alt="Pallet Stacking" />
                            </div>

                            <div className="blogtext">
                                <span>28 October 2023</span>
                                <p className="blogTitle">Pallet Stacking for Efficient Shipping with Glovi</p>
                                <p>Palletizing your shipments is an art that, when done right, can streamline your shipping process
                                    and maximize efficiency. Whether you're a business ow.. <a href="/PalletStacking">Read More</a></p>
                            </div>
                        </div>

                        {/* Blogbox2 */}
                        <div className="blogbox">
                            <div className="blogImg">
                                <img src={MasterArt} alt="Mastering the Art of Packaging" />
                            </div>

                            <div className="blogtext">
                                <span>28 October 2023</span>
                                <p className="blogTitle">Mastering the Art of Packaging</p>
                                <p>Sending a package is more than just putting items in a box. The way you package your items plays a
                                     crucial role in ensuring they reach their destinati...<a href="/MasteringtheArt">Read More</a></p>
                            </div>
                        </div>

                        {/* Blogbox3 */}
                        <div className="blogbox">
                            <div className="blogImg">
                                <img src={Prohibited} alt="Understanding Prohibited Items" />
                            </div>

                            <div className="blogtext">
                                <span>28 October 2023</span>
                                <p className="blogTitle">Understanding Prohibited Items</p>
                                <p>Palletizing your shipments is an art that, when done right, can streamline your shipping process
                                    and maximize efficiency. Whether you're a business ow..<a href="/UnderstandingProhibitedItems">Read More</a></p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <Footer />
        </>
    )
}

export default Blogs