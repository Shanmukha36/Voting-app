Here is a complete `README.md` template based on the architecture and flow shown in your screenshots. You can copy this directly into your GitHub repository.

---

```markdown
# Highly Available Voting Application on AWS

## Overview
This project demonstrates the deployment of a highly available, scalable PHP web application ("Vote for the Best Phone Brand!") on Amazon Web Services (AWS). It utilizes an Auto Scaling Group (ASG) and an Application Load Balancer (ALB) to ensure traffic is distributed evenly across multiple EC2 instances, providing fault tolerance and seamless scaling.

## Architecture Components
Based on the AWS Management Console configuration, this project implements the following resources:
* **Launch Template (`voting-app`):** Defines the underlying EC2 configuration, including the AMI, instance type (`t2.micro`), and user data script to bootstrap the Apache server and PHP application.
* **Target Group (`voting-tb`):** Routes requests to registered EC2 targets on HTTP Port 80.
* **Application Load Balancer (`voting-lb`):** An internet-facing load balancer spanning 3 Availability Zones, distributing incoming user traffic to the healthy instances in the Target Group.
* **Auto Scaling Group (`voting-asg`):** Maintains a desired capacity of 2 instances to ensure high availability. It dynamically scales the EC2 instances using the `voting-app` launch template and automatically registers them with the Target Group.

---

## Creation Flow & Setup Instructions

### Step 1: Create the Launch Template
1. Navigate to **EC2 Dashboard > Launch Templates**.
2. Create a new template named **`voting-app`**.
3. Select an Amazon Linux or Ubuntu AMI and set the instance type to `t2.micro`.
4. In the **Advanced Details > User Data** section, provide the bash script to install Apache, PHP, and deploy the application source code (e.g., `index.php`).

### Step 2: Configure the Target Group
1. Navigate to **EC2 Dashboard > Target Groups**.
2. Create a new target group named **`voting-tb`**.
3. Set the target type to **Instances**.
4. Configure the Protocol to **HTTP** and Port to **80**.
5. Select your default VPC and configure the health checks to ensure traffic only flows to healthy PHP servers.

### Step 3: Provision the Application Load Balancer
1. Navigate to **EC2 Dashboard > Load Balancers**.
2. Create an **Application Load Balancer** named **`voting-lb`**.
3. Set the scheme to **Internet-facing** and the IP address type to **IPv4**.
4. Select your VPC and map it across 3 Availability Zones (e.g., `ap-south-1a`, `ap-south-1b`, `ap-south-1c`).
5. Configure the listener on Port 80 to forward traffic to the `voting-tb` Target Group.

### Step 4: Setup the Auto Scaling Group
1. Navigate to **EC2 Dashboard > Auto Scaling Groups**.
2. Create an ASG named **`voting-asg`**.
3. Select the `voting-app` Launch Template created in Step 1.
4. Attach the ASG to the existing load balancer target group (`voting-tb`).
5. Set the capacity limits:
   * **Desired capacity:** 2
   * **Minimum capacity:** 2
   * **Maximum capacity:** 4
6. Once launched, verify in the EC2 console that the instances are running and pass the `2/2` status checks.

### Step 5: Verify the Deployment
1. Go to the Load Balancer dashboard and copy the **DNS name** (e.g., `voting-lb-1383968828.ap-south-1.elb.amazonaws.com`).
2. Paste the URL into a web browser.
3. The PHP voting application should load successfully.
4. **Validation:** Check the "Server Handling Request" section at the bottom of the app interface. As you refresh the page, you should see the internal IP address change, confirming that the ALB is successfully routing traffic between the different EC2 instances in your Auto Scaling Group.

---

## Author
**Badri Shanmukha**

```
