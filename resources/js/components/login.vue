<template>
    <div class="mian">
        <div class="logincard">
            <div class="logincardLeft">

            </div>
            <div class="logincardRight">
                <span class="logintitle">登录</span>
                <div class="inputdiv">
                    <el-input v-model="username" placeholder="账号" ></el-input>
                </div>
                <div class="inputdiv">
                    <el-input type="password"v-model="password" placeholder="密码"></el-input>
                </div>
                <div class="inputdiv2">
                    <el-button type="primary" class="loginbtn" v-on:click="submit">登录</el-button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                username:'',
                password:''
            }
        },
        methods:{
            submit(){
                console.log(111)
                this.axios.post('/api/admin/login',{
                    username:this.username,
                    password:this.password
                }).then(function(res){
                    console.log(res.data)
                }).catch(function (err){
                    console.log(err)
                    //
                }
                )

            }
        }
    }
</script>
<style scoped>

    .mian{
        width: 100%;
        height: 100%;
        /*border:1px solid red;*/
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .logincard{
        width: 1000px;
        height: 500px;
        border: 1px solid #2f77e3 ;
        border-radius: 14px;
        box-shadow: 8px 3px 20px #2f77e3;
        background-color: #ffffff;
        float: left;
    }
    .logincardLeft{
        width: 64%;
        height: 100%;
        background-image: linear-gradient(to right , #2f77e3, #6baee6);
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
        float: left;
        /*border:1px solid red;*/
    }
    .logincardRight{
        width: 36%;
        height: 100%;
        /*display: flex;*/
        /*align-items: center;*/
        /*justify-content: center;*/
        float: left;
        /*border:1px solid red;*/
    }
    .logintitle{
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 100px;
        font-size:20px;
        color:#2f77e3;
    }
    .inputdiv{
        margin-top: 30px;
        width: 80%;
        margin-left: 10%;
    }
    .inputdiv2{
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 30px;
        width: 80%;
        margin-left: 10%;
    }
    .loginbtn{
        width: 100%;
    }
</style>