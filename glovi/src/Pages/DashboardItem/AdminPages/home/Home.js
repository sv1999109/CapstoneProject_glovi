import Chart from "../../AdminComponents/chart/Chart";
import FeaturedInfo from "../../AdminComponents/featuredInfo/FeaturedInfo";
import "./home.css";
import Sidebar from '../../AdminComponents/sidebar/Sidebar';
import Topbar from '../../AdminComponents/topbar/Topbar';




export default function Home() {


  const data = [
    { name: "Shipment 1", pending: 10, shipped: 20, delivered: 15 },
    { name: "Shipment 2", pending: 15, shipped: 25, delivered: 20 },
    // Add more data as needed
  ];
 

  return (
    <>
    <Topbar/>
    <div className="flex justify-between">
    <Sidebar/>
    <div className="home">
      <span style={{marginTop: "150px"}}><FeaturedInfo/></span> 
      <Chart title="Shipments Overview" data={data} grid={true} />
    </div>
    </div>
    </>
  );
}
