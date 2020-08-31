@extends('frontend.layouts.app')
@section('seo')
<?php
$title = 'Sim '.$info->number_sim_tring.' - '.$info->name_genre.' - sim số đẹp - '.$info->number_sim;
$title_seo = $info->seo_title !='' ? $info->seo_title : $title;
$desc = $info->number_sim_tring.' thuộc dòng '.$info->name_genre.' đầu số '.$info->name_network.' '.$info->price.' tại muasim. Mua sim số đẹp '.$info->number_sim_tring.',sim so dep, so dep, sim dep, mua sim so dep';
$seo_description = $info->seo_description !='' ? $info->seo_description : $desc;
$keywords = 'Mua Sim '.$info->number_sim_tring.',bán sim '.$info->number_sim.',giá sim '.$info->price.' - '.$info->number_sim.',mua sim so dep, mua sim, sim so dep, sim dep, so dep, sim so, sim gia re, sim so dep gia re, sim số giá rẻ, mua ban sim, giá sim số đẹp, chon so dep';
$keywords_seo = $info->seo_keyword !='' ? $info->seo_keyword : $keywords;
  $data_seo = array(
      'title' => $title_seo,
      'keywords' => $keywords_seo,
      'description' => $seo_description,
      'og_title' => $title,
      'og_description' => $seo_description,
      'og_url' => Request::url(),
      'og_img' => \App\myHelper::get_option_seo('seo-image-add','image'),
      'current_url' =>Request::url(),
      'current_url_amp' =>''
  );
  $seo = WebService::getSEO($data_seo);
  ?>
@include('frontend.partials.seo')
@endsection
@section('content')
<div class="head head_nohome">
   <div class="dbreadcrumbs">
      <div class="container">
         <div class="breadcrumbs_wrapper" itemscope="" itemtype="http://schema.org/WebPage">
            <ul class="breadcrumb" itemscope="itemscope" itemtype="https://schema.org/BreadcrumbList">
               <li class="breadcrumb__item" itemprop="itemListElement" itemscope="itemscope" itemtype="http://schema.org/ListItem">
                  <a title="{{ config('app.name') }}" href="{{URL::to('/')}}" itemprop="item">
                     <span itemprop="name">Trang chủ</span>
                     <meta content="1" itemprop="position">
                  </a>
               </li>
               <li class="breadcrumb__item" itemprop="itemListElement" itemscope="itemscope" itemtype="http://schema.org/ListItem">
                  <a title="{{@$info->name_genre}}" href="{{route('category.list_slug1',array(@$info->slug_genre))}}" itemprop="item">
                     <span itemprop="name">{{@$info->name_genre}}</span>
                     <meta content="2" itemprop="position">
                  </a>
               </li>
               <li class="breadcrumb__item" itemprop="itemListElement" itemscope="itemscope" itemtype="http://schema.org/ListItem">
                  
                     <span itemprop="name">{{@$info->number_sim_tring}}</span>
                     <meta content="3" itemprop="position">
               </li>
            </ul>
         </div>
      </div>
   </div>
   <div class="clear"></div>
   <div class="wrapper_content_p cls">
      <div class="main_wrapper container cls ">
         <div class="wrapper_content nohome">
            <div class="main-area-right cls">
               <div class="product" id="product_page" itemscope="" itemtype="https://schema.org/Product">
                  <meta itemprop="url" content="{{route('single_sim.list',array(@$info->slug))}}">
                  <div class="image_detail">
                     <div class="page_title_sim">
                        <h1 itemprop="name"><span>Thông tin số sim {{@$info->number_sim_tring}}</span></h1>
                     </div>
                     <div class="accessories_copo hide" itemprop="description">
                        <p>MUA SIM SỐ ĐẸP - CHỌN SỐ  VINA, MOBI, VIETTEL GIÁ RẺ</p>
                     </div>
                     <div class="wrapper_img">
                      <?php 
                     $image = WebService::get_image_sim(@$info->image_url,$info->number_sim,$info->price,$info->name_genre,$info->id_category_network);
                       ?>
                        <div class="image_sim"><img itemprop="image" src="{{$image}}" alt="{{@$info->number_sim}}">   </div>
                        <div class="top_right">
                           <ul>
                              <li>Sim số đẹp: <span class="price">{{@$info->number_sim_tring}}</span></li>
                              <li>Giá bán: <span class="price price_sell">{!!\App\myHelper::convert_money(@$info->price)!!} ₫</span></li>
                              <li class="color_0">Mạng di động: <span class="image">
                                 </span>{{@$info->name_network}}
                              </li>
                              <span class="manufactory hide" itemprop="brand" itemscope="" itemtype="https://schema.org/Brand">
                                 <meta itemprop="name" content="Viettel">
                              </span>
                              <li>Loại sim: <a href="{{route('category.list_slug1',array(@$info->slug_genre))}}" title="{{@$info->name_genre}}"><span class="red">{{@$info->name_genre}}</span></a></li>
                             
                           </ul>
                           <div class="price cls" itemprop="offers" itemscope="" itemtype="https://schema.org/Offer">
                              <meta itemprop="url" content="{{route('single_sim.list',array(@$info->number_sim))}}">
                              <meta itemprop="availability" content="https://schema.org/InStock">
                              <meta itemprop="price" content="{{@$info->price}}">
                              <!-- <meta itemprop="offerCount" name="offerCount" content="1"> -->
                              <meta itemprop="priceCurrency" content="VND">
                              <meta itemprop="priceValidUntil" content="2020/08/06">
                              <div class="seller hide" itemprop="seller" itemscope="" itemtype="http://schema.org/Organization">
                                 <meta itemprop="name" content="{{ config('app.name') }}">
                                 <meta itemprop="url" content="{{route('single_sim.list',array(@$info->number_sim))}}">
                              </div>
                           </div>
                           <span class="code hide">
                              <meta itemprop="sku" content="{{@$info->price}}">
                              <meta itemprop="mpn" content="{{@$info->price}}">
                           </span>
                        
                        </div>
                     </div>
                  </div>
                  <div class="sims">
                     <div class="clear"></div>
                     <div class="image_detail">
                        <div class="page_title_sim cart_sims">
                           <span>Đặt mua sim {{$info->number_sim_tring}}</span>
                        </div>
                        <div class="sim_order">
                            @if(Session::has('notify'))
                            <div class="mgt-10  alert alert-success alert-dismissible fade in" role="alert">
                                 {{ Session::get('notify') }}
                            </div>
                            @endif
                           <form action="{{route('category.order_sim')}}" name="order" method="post" class="form_order">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <!--	CONTENT IN FRAME	-->
                              <div id="msg_error"></div>
                              <input type="hidden" value="{{$info->id}}" name="id_sim">
                              <div class="info-customer-gh">
                                 <!--	INFO OF RECIPIENTS			-->
                                 <div class="info-customer-gh-receive">
                                    <table width="100%" border="0" cellpadding="5">
                                       <tbody>
                                          <tr>
                                             <td width="20%" class="td-left"> Họ và tên: <font color="#E06311">(*)</font></td>
                                             <td width="80%"><input type="text" name="name_customer" id="name_customer" value="{{old('name_customer')}}" placeholder="Họ và tên" class="input_text" size="28">
                                             @if($errors->has('name_customer'))
                                                  <div class="error"><?php echo $errors->first('name_customer');
                                                   ?></div>
                                              @endif
                                          </td>
                                          </tr>
                                          <tr>
                                             <td class="td-left"> Địa chỉ: <font color="#E06311">(*)</font></td>
                                             <td><input type="text" name="address_customer" id="address_customer" value="{{old('address_customer')}}" placeholder="Địa chỉ"  class="input_text" size="28">
                                              @if($errors->has('address_customer'))
                                                <div class="error"><?php echo $errors->first('address_customer');
                                                 ?></div>
                                            @endif</td>
                                          </tr>
                                         
                                          <tr>
                                             <td class="td-left"> Điện thoại: <font color="#E06311">(*)</font></td>
                                             <td><input type="tel" name="phone_customer" id="phone_customer" value="{{old('phone_customer')}}" placeholder="Điện thoại" class="input_text" size="28">
                                              @if($errors->has('phone_customer'))
                                                  <div class="error"><?php echo $errors->first('phone_customer');
                                                   ?></div>
                                              @endif</td>
                                          </tr>
                                          <tr>
                                             <td class="td-left"> Email: <font color="#E06311">(*)</font></td>
                                             <td><input type="email" name="email_customer" id="email_customer" value="{{old('email_customer')}}" placeholder="Email" class="input_text" size="28">
                                              @if($errors->has('email_customer'))
                                              <div class="error"><?php echo $errors->first('email_customer');
                                               ?></div>
                                          @endif</td>
                                          </tr>
                                           <tr>
                                             <td class="td-left">Thông tin khác</td>
                                             <td><label>
                                               <textarea name="note_customer" id="note_customer" class="textarea" rows="5" cols="57">{{old('note_customer')}}</textarea>
                                                @if($errors->has('note_customer'))
                                                    <div class="error"><?php echo $errors->first('note_customer');
                                                     ?></div>
                                                @endif
                                             </label></td>
                                              </tr>
                                          <tr>
                                             <td class="td-left">&nbsp;</td>
                                             <td class="nows_s">
                                                <button type="submit" class="button" id="submitbt">
                                                <span>&nbsp;Đặt hàng&nbsp;</span>
                                                </button>
                                                <span class="hotline">Đặt sim trực tuyến qua hotline: <font>0909.234.234</font></span>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                                 <!--	end INFO OF SENDER			-->
                              </div>
                              <input type="hidden" name="id_sim" value="{{$info->id}}">
                              <!--	end CONTENT IN FRAME	-->
                           </form>
                        </div>
                        <div class="clear"></div>
                        <div class="streng_box">
                           <div class="block_strengths strengths_0 blocks_strengths blocks0 block" id="block_id_192">
                              <div class="strengths_retangle4_block cls">
                                 <div class="item item_1 cls">
                                    <div class="item-inner">
                                       <div class="item-l">
                                          <div class="isvg">
                                             <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20" height="20" viewBox="0 0 438.526 438.526" style="enable-background:new 0 0 438.526 438.526;" xml:space="preserve">
                                                <g>
                                                   <path d="M435.969,157.878c-1.708-1.712-3.897-2.568-6.57-2.568H303.778c17.7,0,32.784-6.23,45.255-18.699 c12.464-12.468,18.699-27.552,18.699-45.254s-6.235-32.786-18.699-45.254c-12.471-12.465-27.555-18.699-45.255-18.699 c-20.365,0-36.356,7.327-47.965,21.982l-36.547,47.108l-36.54-47.108c-11.613-14.655-27.6-21.982-47.967-21.982 c-17.703,0-32.789,6.23-45.253,18.699c-12.465,12.468-18.7,27.552-18.7,45.254s6.231,32.79,18.7,45.254 c12.467,12.465,27.55,18.699,45.253,18.699H9.135c-2.667,0-4.854,0.856-6.567,2.568C0.857,159.593,0,161.783,0,164.446v91.367 c0,2.662,0.854,4.853,2.568,6.563c1.712,1.711,3.903,2.566,6.567,2.566h27.41v118.776c0,7.618,2.665,14.086,7.995,19.41 c5.326,5.332,11.798,7.994,19.414,7.994h310.629c7.618,0,14.086-2.662,19.417-7.994c5.325-5.328,7.995-11.799,7.995-19.41V264.942 h27.397c2.669,0,4.859-0.855,6.57-2.566s2.563-3.901,2.563-6.563v-91.367C438.529,161.783,437.68,159.593,435.969,157.878z M284.081,72.798c4.948-5.898,11.512-8.848,19.697-8.848c7.618,0,14.089,2.662,19.418,7.992c5.324,5.327,7.987,11.8,7.987,19.414 s-2.67,14.087-7.987,19.414c-5.332,5.33-11.8,7.992-19.418,7.992h-55.391L284.081,72.798z M134.756,118.763 c-7.614,0-14.082-2.663-19.42-7.992c-5.327-5.327-7.993-11.8-7.993-19.414s2.663-14.084,7.993-19.414 c5.33-5.33,11.803-7.992,19.417-7.992c8.188,0,14.753,2.946,19.702,8.848l35.975,45.965H134.756z M264.951,210.128v133.62v15.985 c0,4.76-1.719,8.422-5.141,10.995c-3.429,2.57-7.809,3.856-13.131,3.856H191.86c-5.33,0-9.707-1.286-13.134-3.856 c-3.427-2.573-5.142-6.235-5.142-10.995v-15.985v-133.62V155.31h91.367V210.128z"></path>
                                                </g>
                                             </svg>
                                          </div>
                                       </div>
                                       <div class="item-r">
                                          <span class="summary">
                                             <p>Quý khách hàng khi mua sim đều được hưởng toàn bộ các khuyến mãi hiện hành của các nhà mạng Viettel, Vinaphone, Mobifone giống như các loại sim thông thường khác.</p>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="clear"></div>
                                 <div class="item item_2 cls">
                                    <div class="item-inner">
                                       <div class="item-l">
                                          <div class="isvg">
                                             <svg width="20" height="20" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                <g>
                                                   <g>
                                                      <path d="M123.733,130.133c-17.067-17.067-89.6-21.333-113.067-23.467c-2.133,0-4.267,0-6.4,2.133C2.133,110.933,0,115.2,0,117.333	v192C0,315.733,4.267,320,10.667,320h64c4.267,0,8.533-2.133,10.667-6.4c0-6.4,38.4-119.467,42.667-174.933	C128,136.533,128,132.267,123.733,130.133z"></path>
                                                   </g>
                                                </g>
                                                <g>
                                                   <g>
                                                      <path d="M352,181.333c-21.333-6.4-40.533-14.933-57.6-21.333c-38.4-17.067-55.467-8.533-89.6,25.6 c-14.933,14.933-25.6,36.267-23.467,44.8c0,2.133,0,2.133,4.267,4.267c10.667,4.267,25.6,6.4,40.533-17.067 c2.133-2.133,4.267-4.267,8.533-4.267c6.4,0,8.533-2.133,14.933-4.267c4.267-2.133,8.533-4.267,14.933-6.4 c2.133,0,2.133,0,4.267,0c2.133,0,6.4,2.133,8.533,2.133C288,215.467,307.2,230.4,326.4,247.467 c29.867,23.467,59.733,49.067,74.667,68.267h2.133C388.267,273.067,362.667,200.533,352,181.333z"></path>
                                                   </g>
                                                </g>
                                                <g>
                                                   <g>
                                                      <path d="M501.333,128c-83.2,0-130.133,21.333-132.267,21.333c-2.133,2.133-4.267,4.267-6.4,6.4c0,2.133,0,6.4,2.133,8.533	c12.8,21.333,55.467,138.667,61.867,168.533c2.133,4.267,6.4,8.533,10.667,8.533h64c6.4,0,10.667-4.267,10.667-10.667v-192 C512,132.267,507.733,128,501.333,128z"></path>
                                                   </g>
                                                </g>
                                                <g>
                                                   <g>
                                                      <path d="M386.133,337.067c-8.533-19.2-44.8-46.933-76.8-72.533C292.267,249.6,275.2,236.8,262.4,226.133	c-2.133,2.133-6.4,2.133-6.4,4.267c-6.4,2.133-8.533,4.267-17.067,4.267C221.867,256,200.533,264.533,177.067,256 c-10.667-2.133-17.067-10.667-19.2-19.2c-4.267-21.333,14.933-51.2,29.867-66.133h-42.667c-8.533,42.667-23.467,98.133-34.133,128 c8.533,8.533,17.067,19.2,23.467,23.467c40.533,34.133,87.467,68.267,96,74.667c6.4,4.267,19.2,8.533,25.6,8.533 c2.133,0,4.267,0,6.4,0L228.267,371.2c-4.267-4.267-4.267-10.667,0-14.933s10.667-4.267,14.933,0l42.667,42.667 c4.267,4.267,8.533,2.133,12.8,2.133c6.4-2.133,8.533-6.4,10.667-12.8L260.267,339.2c-4.267-4.267-4.267-10.667,0-14.933 s10.667-4.267,14.933,0l53.333,53.333c2.133,2.133,10.667,2.133,17.067,0c2.133-2.133,6.4-4.267,8.533-8.533L294.4,309.333 c-4.267-4.267-4.267-10.667,0-14.933s10.667-4.267,14.933,0l61.867,61.867c4.267,2.133,8.533,0,12.8-2.133 C386.133,352,390.4,345.6,386.133,337.067z"></path>
                                                   </g>
                                                </g>
                                             </svg>
                                          </div>
                                       </div>
                                       <div class="item-r">
                                          <span class="summary">
                                             <p><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:14px">Cam kết toàn bộ sim số đẹp tại website đều là sim mới và chưa có người sử dụng.</span></span></p>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="clear"></div>
                                 <div class="item item_3 cls">
                                    <div class="item-inner">
                                       <div class="item-l">
                                          <div class="isvg">
                                             <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20" height="20" viewBox="0 0 32.75 32.75" style="enable-background:new 0 0 32.75 32.75;" xml:space="preserve">
                                                <g>
                                                   <g>
                                                      <path d="M29.375,1.25h-1.124c0.028-0.093,0.058-0.186,0.058-0.289C28.309,0.43,27.878,0,27.348,0 c-0.531,0-0.961,0.431-0.961,0.961c0,0.103,0.028,0.196,0.059,0.289h-3.68c0.029-0.093,0.058-0.186,0.058-0.289 C22.823,0.43,22.393,0,21.861,0C21.331,0,20.9,0.431,20.9,0.961c0,0.103,0.029,0.196,0.059,0.289h-3.68 c0.029-0.093,0.058-0.186,0.058-0.289C17.337,0.43,16.906,0,16.376,0c-0.53,0-0.961,0.431-0.961,0.961 c0,0.103,0.029,0.196,0.058,0.289h-3.68c0.029-0.093,0.058-0.186,0.058-0.289C11.851,0.43,11.42,0,10.89,0 c-0.531,0-0.961,0.431-0.961,0.961c0,0.103,0.028,0.196,0.058,0.289h-3.68c0.03-0.093,0.058-0.186,0.058-0.289 C6.365,0.43,5.935,0,5.404,0C4.873,0,4.443,0.431,4.443,0.961c0,0.103,0.029,0.196,0.058,0.289H3.375 c-1.517,0-2.75,1.233-2.75,2.75v26c0,1.518,1.233,2.75,2.75,2.75H26.27l5.855-5.855V4C32.125,2.483,30.893,1.25,29.375,1.25z M3.375,31.25c-0.689,0-1.25-0.561-1.25-1.25V9h28.5v17.273l-0.311,0.311h-2.356c-1.101,0-2,0.9-2,2v2.355l-0.31,0.311H3.375z"></path>
                                                      <path d="M19.52,12.536l-1.136,1.232l-0.692,0.749l-7.615,8.252l-1.058,3.662l-0.7,2.422l2.356-0.893l3.565-1.352l7.615-8.25 l0.691-0.75l1.135-1.234c1.062-1.148,0.989-2.941-0.16-4.002C22.371,11.314,20.58,11.387,19.52,12.536z M10.294,27.609 l-0.897-0.827l1.011-3.496l0.269,0.039l2.919,2.692l0.086,0.311L10.294,27.609z M22.204,17.293l-3.481-3.213l0.822-0.892l3.482,3.212L22.204,17.293z"></path>
                                                   </g>
                                                </g>
                                             </svg>
                                          </div>
                                       </div>
                                       <div class="item-r">
                                          <span class="summary">
                                             <p><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:14px">Hỗ trợ khách hàng đăng ký sim chính chủ khi mua sim số đẹp tại đây.</span></span></p>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="clear"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="image_detail">
                        <div class="page_title_sim book_sims">
                           <span>Hướng dẫn mua hàng</span>
                        </div>
                        <div class="streng_text">
                           <div><span style="font-size:18px"><strong>Cách thức mua sim</strong></span></div>
                           <p>Đặt mua sim trên website hoặc điện hotline: 0909.234.234 - 0919.234.234</p>
                           <p>NVKD sẽ gọi lại tư vấn và xác nhận đơn hàng</p>
                           <p>Nhận sim tại nhà, kiểm tra thông tin chính chủ và thanh toán cho người giao sim</p>
                           <div><span style="font-size:18px"><strong>Cách thức mua sim</strong></span></div>
                           <p>Cách 1: <strong>MUABANSIMSO</strong> sẽ giao sim trong ngày và thu tiền tại nhà (áp dụng tại các thành phố, thị trấn lớn)</p>
                           <p>Cách 2: Quý khách đến cửa hàng của&nbsp;<strong>MUABANSIMSO</strong> để nhận sim trực tiếp (Danh sách cửa hàng ở chân website)</p>
                           <p>Cách 3: <strong>MUABANSIMSO</strong> sẽ giao sim theo đường bưu điện và thu tiền tại nhà.</p>
                           <div><strong><span style="font-size:18px">Lưu ý:</span></strong></div>
                           <p>Quý khách sẽ không phải thanh toán thêm bất kỳ 1 khoản nào khác ngoài giá sim</p>
                           <p>Chúc quý khách gặp nhiều may mắn khi sở hữu thuê bao này</p>
                        </div>
                     </div>
                    </div>
               </div>
               <div class="clear"></div>
               <div class="pos4 container" style="display: none;">
                  <div class="block_newslist newslist_0 blocks_news_list blocks0 block" id="block_id_186">
                     <div class="block_title"><span>Có thể bạn quan tâm</span></div>
                     <div id="newslist-slideShow">
                        <div class="newslist-home owl-carousel owl-theme owl-responsive-900 owl-loaded">
                           <div class="owl-stage-outer">
                              <div class="owl-stage"></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="block_newslist newslist_0 blocks_news_list blocks0 block" id="block_id_191">
                     <div class="news_list_body cls ">
                        <div class="news-item">
                           <div class="title">
                              <div class="link">
                                 <a href="https://{{ config('app.name') }}/y-nghia-cac-con-so-trong-sim-dien-thoai-n58.html" title="Ý nghĩa các con số trong sim điện thoại">Ý nghĩa các con số trong sim điện thoại      </a> 
                              </div>
                           </div>
                        </div>
                        <div class="news-item">
                           <div class="title">
                              <div class="link">
                                 <a href="https://{{ config('app.name') }}/sim-phong-thuy-n59.html" title="Sim phong thủy chọn mua sim hợp tuổi, hợp mệnh">Sim phong thủy chọn mua sim hợp tuổi, hợp mệnh      </a> 
                              </div>
                           </div>
                        </div>
                        <div class="news-item">
                           <div class="title">
                              <div class="link">
                                 <a href="https://{{ config('app.name') }}/xem-phong-thuy-sim-n112.html" title="Xem phong thủy sim">Xem phong thủy sim      </a> 
                              </div>
                           </div>
                        </div>
                        <div class="news-item">
                           <div class="title">
                              <div class="link">
                                 <a href="https://{{ config('app.name') }}/sim-viettel-10-so-037-n667.html" title="Sim viettel 10 số 037 ">Sim viettel 10 số 037       </a> 
                              </div>
                           </div>
                        </div>
                        <div class="news-item">
                           <div class="title">
                              <div class="link">
                                 <a href="https://{{ config('app.name') }}/dau-sim-so-dep-084-cua-mang-nao-n668.html" title="Đầu sim số đẹp 084 của mạng nào?">Đầu sim số đẹp 084 của mạng nào?      </a> 
                              </div>
                           </div>
                        </div>
                        <div class="news-item">
                           <div class="title">
                              <div class="link">
                                 <a href="https://{{ config('app.name') }}/sim-tu-quy-nam-sinh-viettel-n669.html" title="Sim tứ quý năm sinh viettel">Sim tứ quý năm sinh viettel      </a> 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
           <div class='right'>
               @include('frontend.sidebar')
            </div>
         </div>
      </div>
   </div>
</div>
@endsection